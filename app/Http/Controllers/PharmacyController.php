<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\MedicineStock;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Dashboard utama Apotek
     */
    public function index()
    {
        // Hitung resep yang belum ditebus (is_dispensed = false)
        $pendingPrescriptionsCount = MedicalRecord::whereHas('prescriptions', function($q) {
            $q->where('is_dispensed', false);
        })->count();

        $lowStockMedicines = MedicineStock::where('quantity', '<=', 10)->with('medicine')->get();

        return view('pharmacy.index', compact('pendingPrescriptionsCount', 'lowStockMedicines'));
    }

    /**
     * Menampilkan daftar resep yang masuk dari dokter
     */
    public function transactionResep(Request $request)
    {
        // Ambil semua Medical Record yang punya resep, tapi belum ditebus (belum di-dispense)
        $records = MedicalRecord::with(['patient', 'doctor', 'prescriptions.medicine'])
            ->whereHas('prescriptions', function($q) {
                $q->where('is_dispensed', false);
            })
            ->latest('record_date')
            ->paginate(10);

        return view('pharmacy.transaction-resep', compact('records'));
    }

    /**
     * Proses penebusan resep (Mengurangi stok obat dan menandai resep sbg selesai)
     */
    public function processResep(Request $request, $medical_record_id)
    {
        $record = MedicalRecord::with('prescriptions.medicine')->findOrFail($medical_record_id);

        DB::beginTransaction();
        try {
            foreach ($record->prescriptions as $prescription) {
                // Jangan proses yang sudah ditebus
                if ($prescription->is_dispensed) continue;

                // Kurangi stok obat (ambil dari batch terlama / stock pertama yang cukup)
                $qtyNeeded = $prescription->quantity;
                $stocks = MedicineStock::where('medicine_id', $prescription->medicine_id)
                    ->where('quantity', '>', 0)
                    ->orderBy('expiry_date', 'asc') // FIFO
                    ->get();

                foreach ($stocks as $stock) {
                    if ($qtyNeeded <= 0) break;

                    if ($stock->quantity >= $qtyNeeded) {
                        $stock->decrement('quantity', $qtyNeeded);
                        $qtyNeeded = 0;
                    } else {
                        $qtyNeeded -= $stock->quantity;
                        $stock->update(['quantity' => 0]);
                    }
                }

                if ($qtyNeeded > 0) {
                    throw new \Exception("Stok obat {$prescription->medicine->name} tidak mencukupi. Kurang {$qtyNeeded} lagi.");
                }

                // Tandai resep sudah ditebus
                $prescription->update(['is_dispensed' => true]);
            }

            DB::commit();

            return redirect()->route('pharmacy.transaction-resep')
                ->with('success', 'Resep berhasil diproses. Obat siap diserahkan ke pasien!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses resep: ' . $e->getMessage());
        }
    }

    /**
     * Penjualan Obat Bebas (Tanpa Resep)
     */
    public function penjualanBebas()
    {
        $medicines = Medicine::where('active', true)->orderBy('name')->get();
        return view('pharmacy.penjualan-bebas', compact('medicines'));
    }

    public function processPenjualanBebas(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create Payment
            $payment = \App\Models\Payment::create([
                'payment_type' => 'pharmacy_sale',
                'customer_name' => 'Pembeli Umum (Apotek)',
                'invoice_number' => 'INV-AP-' . time() . '-' . rand(10,99),
                'total_amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'status' => 'paid', // Langsung lunas di kasir apotek
                'paid_at' => now(),
                'processed_by' => auth()->id() ?? 1,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                
                // Kurangi stok (FIFO)
                $qtyNeeded = $item['quantity'];
                $stocks = MedicineStock::where('medicine_id', $medicine->id)
                    ->where('quantity', '>', 0)
                    ->orderBy('expiry_date', 'asc')
                    ->get();

                foreach ($stocks as $stock) {
                    if ($qtyNeeded <= 0) break;
                    if ($stock->quantity >= $qtyNeeded) {
                        $stock->decrement('quantity', $qtyNeeded);
                        $qtyNeeded = 0;
                    } else {
                        $qtyNeeded -= $stock->quantity;
                        $stock->update(['quantity' => 0]);
                    }
                }

                if ($qtyNeeded > 0) {
                    throw new \Exception("Stok obat {$medicine->name} tidak mencukupi. Kurang {$qtyNeeded} lagi.");
                }

                // Add Payment Item
                $payment->items()->create([
                    'description' => $medicine->name . ' (' . $medicine->code . ')',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return redirect()->route('payments.show', $payment->id)
                ->with('success', 'Transaksi penjualan bebas berhasil. Struk siap dicetak.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    // ... sisanya untuk PO & Mutasi bisa ditambahkan menyusul
    public function pembuatanPO()
    {
        return redirect()->route('purchase-orders.create');
    }

    public function penerimaan()
    {
        $confirmedPOs = \App\Models\PurchaseOrder::with('supplier')
            ->where('status', 'CONFIRMED')
            ->orderBy('updated_at', 'asc')
            ->paginate(10);
            
        return view('pharmacy.penerimaan', compact('confirmedPOs'));
    }

    public function mutasiBarang()
    {
        return view('pharmacy.mutasi-barang');
    }

    public function stockBarang()
    {
        $stocks = MedicineStock::with('medicine')->paginate(15);
        return view('pharmacy.stock-barang', compact('stocks'));
    }
}
