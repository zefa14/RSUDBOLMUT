<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Medicine;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->orderBy('created_at', 'desc')->paginate(10);
        return view('pharmacy.purchase-order.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('active', true)->get();
        $medicines = Medicine::where('active', true)->get();
        return view('pharmacy.purchase-order.create', compact('suppliers', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders',
            'invoice_number' => 'nullable|string',
            'invoice_date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse' => 'required|string',
            'payment_type' => 'required|in:TUNAI,KREDIT',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.expiry_date' => 'nullable|date',
            'items.*.batch_number' => 'nullable|string',
        ]);

        $po = new PurchaseOrder();
        $po->po_number = $validated['po_number'];
        $po->invoice_number = $validated['invoice_number'] ?? null;
        $po->invoice_date = $validated['invoice_date'] ?? now();
        $po->supplier_id = $validated['supplier_id'];
        $po->warehouse = $validated['warehouse'];
        $po->payment_type = $validated['payment_type'];
        $po->tax_percent = $validated['tax_percent'] ?? 0;

        $subtotal = 0;
        $discount_total = 0;

        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['price'];
            $itemDiscount = ($itemSubtotal * ($item['discount_percent'] ?? 0)) / 100;
            $subtotal += $itemSubtotal;
            $discount_total += $itemDiscount;
        }

        $po->subtotal = $subtotal;
        $po->discount_amount = $discount_total;
        $po->tax_amount = (($subtotal - $discount_total) * $po->tax_percent) / 100;
        $po->total = $subtotal - $discount_total + $po->tax_amount;
        $po->status = 'DRAFT';
        $po->save();

        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['price'];
            $itemDiscount = ($itemSubtotal * ($item['discount_percent'] ?? 0)) / 100;
            $itemAfterDiscount = $itemSubtotal - $itemDiscount;
            $hpp = ($itemAfterDiscount * $po->tax_percent) / 100 + $itemAfterDiscount;

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'medicine_id' => $item['medicine_id'],
                'quantity' => $item['quantity'],
                'unit' => Medicine::find($item['medicine_id'])->unit,
                'price' => $item['price'],
                'subtotal' => $itemSubtotal,
                'discount_percent' => $item['discount_percent'] ?? 0,
                'discount_amount' => $itemDiscount,
                'hpp' => $itemAfterDiscount,
                'hpp_with_tax' => $hpp,
                'expiry_date' => $item['expiry_date'] ?? null,
                'batch_number' => $item['batch_number'] ?? null,
            ]);
        }

        return redirect()->route('purchase-orders.show', $po->id)
            ->with('success', 'Purchase Order berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'items.medicine');
        return view('pharmacy.purchase-order.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'DRAFT') {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Hanya PO dengan status DRAFT yang dapat diedit');
        }

        $suppliers = Supplier::where('active', true)->get();
        $medicines = Medicine::where('active', true)->get();
        return view('pharmacy.purchase-order.edit', compact('purchaseOrder', 'suppliers', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'DRAFT') {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Hanya PO dengan status DRAFT yang dapat diubah');
        }

        $validated = $request->validate([
            'invoice_number' => 'nullable|string',
            'invoice_date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse' => 'required|string',
            'payment_type' => 'required|in:TUNAI,KREDIT',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.expiry_date' => 'nullable|date',
            'items.*.batch_number' => 'nullable|string',
        ]);

        $purchaseOrder->invoice_number = $validated['invoice_number'] ?? null;
        $purchaseOrder->invoice_date = $validated['invoice_date'] ?? now();
        $purchaseOrder->supplier_id = $validated['supplier_id'];
        $purchaseOrder->warehouse = $validated['warehouse'];
        $purchaseOrder->payment_type = $validated['payment_type'];
        $purchaseOrder->tax_percent = $validated['tax_percent'] ?? 0;

        $subtotal = 0;
        $discount_total = 0;

        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['price'];
            $itemDiscount = ($itemSubtotal * ($item['discount_percent'] ?? 0)) / 100;
            $subtotal += $itemSubtotal;
            $discount_total += $itemDiscount;
        }

        $purchaseOrder->subtotal = $subtotal;
        $purchaseOrder->discount_amount = $discount_total;
        $purchaseOrder->tax_amount = (($subtotal - $discount_total) * $purchaseOrder->tax_percent) / 100;
        $purchaseOrder->total = $subtotal - $discount_total + $purchaseOrder->tax_amount;
        $purchaseOrder->save();

        $purchaseOrder->items()->delete();

        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['price'];
            $itemDiscount = ($itemSubtotal * ($item['discount_percent'] ?? 0)) / 100;
            $itemAfterDiscount = $itemSubtotal - $itemDiscount;
            $hpp = ($itemAfterDiscount * $purchaseOrder->tax_percent) / 100 + $itemAfterDiscount;

            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'medicine_id' => $item['medicine_id'],
                'quantity' => $item['quantity'],
                'unit' => Medicine::find($item['medicine_id'])->unit,
                'price' => $item['price'],
                'subtotal' => $itemSubtotal,
                'discount_percent' => $item['discount_percent'] ?? 0,
                'discount_amount' => $itemDiscount,
                'hpp' => $itemAfterDiscount,
                'hpp_with_tax' => $hpp,
                'expiry_date' => $item['expiry_date'] ?? null,
                'batch_number' => $item['batch_number'] ?? null,
            ]);
        }

        return redirect()->route('purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Purchase Order berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'DRAFT') {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Hanya PO dengan status DRAFT yang dapat dihapus');
        }

        $purchaseOrder->delete();
        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order berhasil dihapus');
    }

    /**
     * Confirm purchase order
     */
    public function confirm(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'DRAFT') {
            return back()->with('error', 'Hanya PO dengan status DRAFT yang dapat dikonfirmasi');
        }

        $purchaseOrder->status = 'CONFIRMED';
        $purchaseOrder->save();

        return back()->with('success', 'Purchase Order berhasil dikonfirmasi');
    }

    /**
     * Receive purchase order
     */
    public function receive(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'CONFIRMED') {
            return back()->with('error', 'Hanya PO dengan status CONFIRMED yang dapat diterima');
        }

        $purchaseOrder->status = 'RECEIVED';
        $purchaseOrder->save();

        // Update medicine stocks
        foreach ($purchaseOrder->items as $item) {
            // Find existing stock by batch number and expiry date, or create new
            $stock = \App\Models\MedicineStock::firstOrCreate(
                [
                    'medicine_id' => $item->medicine_id,
                    'batch_number' => $item->batch_number,
                    'expiry_date' => $item->expiry_date,
                ],
                [
                    'quantity' => 0,
                    'hpp' => $item->hpp ?? 0,
                ]
            );

            $stock->quantity += $item->quantity;
            $stock->save();
            
            // Optionally, update the active price in Medicine if HJA is automated
            // $medicine = $item->medicine;
            // $margin = 1.2; // 20% margin
            // $medicine->price = ceil(($item->hpp ?? $medicine->price) * $margin);
            // $medicine->save();
        }

        return back()->with('success', 'Purchase Order diterima dan Stock berhasil ditambahkan sesuai Batch/Expiry');
    }
}
