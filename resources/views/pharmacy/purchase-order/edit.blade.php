@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">
                <i class="bi bi-pencil me-2"></i>Edit Pembelian Obat
            </h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-modern mb-4">
        <div class="card-body p-4">
            <form action="{{ route('purchase-orders.update', $purchaseOrder->id) }}" method="POST" id="poForm">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">No. PO</label>
                        <input type="text" class="form-control" value="{{ $purchaseOrder->po_number }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">No. Faktur</label>
                        <input type="text" name="invoice_number" class="form-control" value="{{ $purchaseOrder->invoice_number }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Faktur</label>
                        <input type="date" name="invoice_date" class="form-control" value="{{ $purchaseOrder->invoice_date?->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Supplier <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected($purchaseOrder->supplier_id == $supplier->id)>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Gudang</label>
                        <select name="warehouse" class="form-select">
                            <option value="GUDANG UTAMA" @selected($purchaseOrder->warehouse == 'GUDANG UTAMA')>GUDANG UTAMA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jenis</label>
                        <select name="payment_type" class="form-select">
                            <option value="TUNAI" @selected($purchaseOrder->payment_type == 'TUNAI')>TUNAI</option>
                            <option value="KREDIT" @selected($purchaseOrder->payment_type == 'KREDIT')>Kas Umum</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold mb-3">Daftar Obat</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Diskon(%)</th>
                                        <th>Subtotal</th>
                                        <th>Exp Date</th>
                                        <th>Batch</th>
                                        <th style="width: 5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseOrder->items as $item)
                                        <tr class="item-row" data-row="{{ $loop->index }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <select name="items[{{ $loop->index }}][medicine_id]" class="form-select form-select-sm medicine-select" onchange="updateItemInfo({{ $loop->index }})">
                                                    <option value="">Pilih Obat</option>
                                                    @foreach ($medicines as $medicine)
                                                        <option value="{{ $medicine->id }}" data-code="{{ $medicine->code }}" data-name="{{ $medicine->name }}" data-unit="{{ $medicine->unit }}" data-price="{{ $medicine->price }}" @selected($item->medicine_id == $medicine->id)>{{ $medicine->code }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><span class="medicine-name" data-row="{{ $loop->index }}">{{ $item->medicine->name }}</span></td>
                                            <td>
                                                <input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control form-control-sm quantity-input" value="{{ $item->quantity }}" min="1" onchange="calculateRow({{ $loop->index }})">
                                            </td>
                                            <td><span class="unit-span" data-row="{{ $loop->index }}">{{ $item->unit }}</span></td>
                                            <td>
                                                <input type="number" name="items[{{ $loop->index }}][price]" class="form-control form-control-sm price-input" value="{{ $item->price }}" min="0" step="0.01" onchange="calculateRow({{ $loop->index }})">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $loop->index }}][discount_percent]" class="form-control form-control-sm discount-input" value="{{ $item->discount_percent }}" min="0" max="100" step="0.01" onchange="calculateRow({{ $loop->index }})">
                                            </td>
                                            <td><span class="subtotal-span" data-row="{{ $loop->index }}">{{ number_format($item->subtotal - $item->discount_amount, 2, ',', '.') }}</span></td>
                                            <td>
                                                <input type="date" name="items[{{ $loop->index }}][expiry_date]" class="form-control form-control-sm" value="{{ $item->expiry_date?->format('Y-m-d') }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $loop->index }}][batch_number]" class="form-control form-control-sm" value="{{ $item->batch_number }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem({{ $loop->index }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                            <i class="bi bi-plus me-2"></i>Tambah Item
                        </button>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted">Total</small>
                                </div>
                                <div class="col-6 text-end">
                                    <strong id="totalSubtotal">{{ number_format($purchaseOrder->subtotal, 2, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted">Diskon</small>
                                </div>
                                <div class="col-6 text-end">
                                    <strong id="totalDiscount">{{ number_format($purchaseOrder->discount_percent, 2, ',', '.') }}%</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Pajak</small>
                                </div>
                                <div class="col-6 text-end">
                                    <input type="number" name="tax_percent" class="form-control form-control-sm" value="{{ $purchaseOrder->tax_percent }}" min="0" max="100" step="0.01" id="taxPercent" style="width: 100px; margin-left: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-primary text-white rounded text-center">
                            <small class="d-block mb-2">TOTAL HARGA</small>
                            <h3 class="fw-bold mb-0" id="totalPrice">{{ number_format($purchaseOrder->total, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill">
                            <i class="bi bi-check-circle me-2"></i>Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const medicines = {!! json_encode($medicines) !!};
let itemCount = {{ count($purchaseOrder->items) }};

function addItem() {
    const row = `
        <tr class="item-row" data-row="${itemCount}">
            <td>${itemCount + 1}</td>
            <td>
                <select name="items[${itemCount}][medicine_id]" class="form-select form-select-sm medicine-select" onchange="updateItemInfo(${itemCount})">
                    <option value="">Pilih Obat</option>
                    ${medicines.map(m => `<option value="${m.id}" data-code="${m.code}" data-name="${m.name}" data-unit="${m.unit}" data-price="${m.price}">${m.code}</option>`).join('')}
                </select>
            </td>
            <td><span class="medicine-name" data-row="${itemCount}">-</span></td>
            <td>
                <input type="number" name="items[${itemCount}][quantity]" class="form-control form-control-sm quantity-input" value="1" min="1" onchange="calculateRow(${itemCount})">
            </td>
            <td><span class="unit-span" data-row="${itemCount}">-</span></td>
            <td>
                <input type="number" name="items[${itemCount}][price]" class="form-control form-control-sm price-input" value="0" min="0" step="0.01" onchange="calculateRow(${itemCount})">
            </td>
            <td>
                <input type="number" name="items[${itemCount}][discount_percent]" class="form-control form-control-sm discount-input" value="0" min="0" max="100" step="0.01" onchange="calculateRow(${itemCount})">
            </td>
            <td><span class="subtotal-span" data-row="${itemCount}">0,00</span></td>
            <td>
                <input type="date" name="items[${itemCount}][expiry_date]" class="form-control form-control-sm">
            </td>
            <td>
                <input type="text" name="items[${itemCount}][batch_number]" class="form-control form-control-sm" placeholder="Batch">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${itemCount})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
    itemCount++;
}

function updateItemInfo(rowNum) {
    const select = document.querySelector(`[name="items[${rowNum}][medicine_id]"]`);
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        document.querySelector(`.medicine-name[data-row="${rowNum}"]`).textContent = option.dataset.name;
        document.querySelector(`.unit-span[data-row="${rowNum}"]`).textContent = option.dataset.unit;
        document.querySelector(`[name="items[${rowNum}][price]"]`).value = option.dataset.price;
        calculateRow(rowNum);
    }
}

function calculateRow(rowNum) {
    const quantity = parseFloat(document.querySelector(`[name="items[${rowNum}][quantity]"]`).value) || 0;
    const price = parseFloat(document.querySelector(`[name="items[${rowNum}][price]"]`).value) || 0;
    const discount = parseFloat(document.querySelector(`[name="items[${rowNum}][discount_percent]"]`).value) || 0;
    
    const subtotal = quantity * price;
    const discountAmount = (subtotal * discount) / 100;
    const total = subtotal - discountAmount;
    
    document.querySelector(`.subtotal-span[data-row="${rowNum}"]`).textContent = total.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    calculateTotal();
}

function calculateTotal() {
    let grandTotal = 0;
    let totalDiscount = 0;
    let itemCount = 0;
    
    document.querySelectorAll('.item-row').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
        
        const subtotal = quantity * price;
        const discountAmount = (subtotal * discount) / 100;
        
        grandTotal += subtotal - discountAmount;
        totalDiscount += discount;
        itemCount++;
    });
    
    const taxPercent = parseFloat(document.getElementById('taxPercent').value) || 0;
    const taxAmount = (grandTotal * taxPercent) / 100;
    const finalTotal = grandTotal + taxAmount;
    
    document.getElementById('totalSubtotal').textContent = grandTotal.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('totalDiscount').textContent = (itemCount > 0 ? totalDiscount / itemCount : 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '%';
    document.getElementById('totalPrice').textContent = finalTotal.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function removeItem(rowNum) {
    document.querySelector(`[data-row="${rowNum}"]`).remove();
    calculateTotal();
}

document.getElementById('addItemBtn').addEventListener('click', addItem);
document.getElementById('taxPercent').addEventListener('change', calculateTotal);

// Calculate initial total
calculateTotal();
</script>
@endsection
