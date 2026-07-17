@extends('layouts.app')

@section('title', 'Penjualan Obat Bebas')
@section('page-title', 'Kasir Apotek')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-cart-plus me-2"></i>Point of Sales (POS) Apotek</h4>
            <p class="text-muted">Layanan kasir penjualan obat bebas dan alat kesehatan umum tanpa E-Resep.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Area Pemilihan Item --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-search me-2"></i>Cari & Tambah Obat</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-end mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Pilih Obat / Barang</label>
                            <select id="medicineSelect" class="form-select border-primary shadow-sm">
                                <option value="" data-price="0" data-unit="">-- Pilih dari Katalog --</option>
                                @foreach($medicines as $med)
                                    <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-price="{{ $med->price }}" data-unit="{{ $med->unit }}" data-code="{{ $med->code }}">
                                        {{ $med->code }} - {{ $med->name }} (Rp {{ number_format($med->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">Jumlah Qty</label>
                            <div class="input-group shadow-sm">
                                <input type="number" id="qtyInput" class="form-control" value="1" min="1">
                                <span class="input-group-text bg-white" id="unitDisplay">Pcs</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3 mt-md-0 d-grid">
                            <button type="button" id="btnAddItem" class="btn btn-primary shadow-sm rounded-3">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3 fw-bold text-secondary">Keranjang Belanja</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="cartTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">Item</th>
                                    <th width="15%" class="text-center">Harga</th>
                                    <th width="15%" class="text-center">Qty</th>
                                    <th width="15%" class="text-end">Subtotal</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Item keranjang akan ditambahkan via JS --}}
                                <tr id="emptyCartRow">
                                    <td colspan="6" class="text-center py-4 text-muted small">
                                        <i class="bi bi-cart-x fs-2 d-block mb-2 text-secondary opacity-25"></i>
                                        Keranjang masih kosong.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Area Pembayaran / Kasir --}}
        <div class="col-lg-4">
            <form action="{{ route('pharmacy.process-penjualan-bebas') }}" method="POST" id="checkoutForm">
                @csrf
                <div id="cartHiddenInputs"></div>

                <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase text-muted fw-bold mb-4 small" style="letter-spacing: 1px;">Rincian Pembayaran</h6>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Total Item:</span>
                            <span class="fw-bold text-dark" id="totalItemsDisplay">0</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-secondary fs-5">Total Harga:</span>
                            <span class="fw-bold text-success fs-4" id="totalPriceDisplay">Rp 0</span>
                            <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <textarea name="notes" class="form-control bg-light" rows="2" placeholder="Opsional..."></textarea>
                        </div>

                        <div class="mb-4 border-top pt-4">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select bg-light mb-3">
                                <option value="cash">Uang Tunai (Cash)</option>
                                <option value="debit">Kartu Debit</option>
                                <option value="qris">QRIS / E-Wallet</option>
                            </select>
                            
                            <label class="form-label fw-semibold">Jumlah Uang Diterima (Rp)</label>
                            <input type="number" id="cashReceived" class="form-control form-control-lg bg-white shadow-sm text-end fw-bold text-primary" placeholder="0">
                        </div>

                        <div class="d-flex justify-content-between mb-4 bg-primary bg-opacity-10 p-3 rounded-3">
                            <span class="text-primary fw-semibold">Kembalian:</span>
                            <span class="fw-bold text-primary fs-5" id="changeDisplay">Rp 0</span>
                        </div>

                        <button type="button" id="btnCheckout" class="btn btn-primary btn-lg w-100 shadow rounded-pill d-flex justify-content-center align-items-center gap-2" disabled>
                            <i class="bi bi-printer"></i> Proses & Cetak Struk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const medicineSelect = document.getElementById('medicineSelect');
        const qtyInput = document.getElementById('qtyInput');
        const unitDisplay = document.getElementById('unitDisplay');
        const btnAddItem = document.getElementById('btnAddItem');
        const cartTableBody = document.querySelector('#cartTable tbody');
        const emptyCartRow = document.getElementById('emptyCartRow');
        const totalItemsDisplay = document.getElementById('totalItemsDisplay');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const totalAmountInput = document.getElementById('totalAmountInput');
        const cartHiddenInputs = document.getElementById('cartHiddenInputs');
        const btnCheckout = document.getElementById('btnCheckout');
        const cashReceived = document.getElementById('cashReceived');
        const changeDisplay = document.getElementById('changeDisplay');

        let cart = [];

        // Ganti label satuan saat obat dipilih
        medicineSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            unitDisplay.textContent = selectedOption.dataset.unit || 'Pcs';
        });

        // Tambah ke keranjang
        btnAddItem.addEventListener('click', function() {
            const medicineId = medicineSelect.value;
            const qty = parseInt(qtyInput.value);

            if (!medicineId || qty <= 0) {
                Swal.fire('Oops', 'Pilih obat dan tentukan jumlah yang benar.', 'warning');
                return;
            }

            const selectedOption = medicineSelect.options[medicineSelect.selectedIndex];
            const item = {
                id: medicineId,
                name: selectedOption.dataset.name,
                code: selectedOption.dataset.code,
                price: parseFloat(selectedOption.dataset.price),
                unit: selectedOption.dataset.unit,
                qty: qty
            };

            // Cek apakah obat sudah ada di keranjang, jika ada tambahkan qty nya
            const existingItemIndex = cart.findIndex(i => i.id === medicineId);
            if (existingItemIndex !== -1) {
                cart[existingItemIndex].qty += qty;
            } else {
                cart.push(item);
            }

            renderCart();
            
            // Reset form
            medicineSelect.value = '';
            qtyInput.value = 1;
            unitDisplay.textContent = 'Pcs';
        });

        function renderCart() {
            // Bersihkan baris selain empty marker
            const rows = cartTableBody.querySelectorAll('tr.cart-item-row');
            rows.forEach(r => r.remove());

            cartHiddenInputs.innerHTML = ''; // Clear hidden inputs

            let totalItems = 0;
            let totalPrice = 0;

            if (cart.length === 0) {
                emptyCartRow.style.display = '';
                btnCheckout.disabled = true;
            } else {
                emptyCartRow.style.display = 'none';
                btnCheckout.disabled = false;

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.qty;
                    totalItems += item.qty;
                    totalPrice += subtotal;

                    const row = document.createElement('tr');
                    row.className = 'cart-item-row';
                    row.innerHTML = `
                        <td class="text-muted">${index + 1}</td>
                        <td class="fw-bold">${item.name} <div class="small fw-normal text-muted">${item.code}</div></td>
                        <td class="text-center">Rp ${formatNumber(item.price)}</td>
                        <td class="text-center"><span class="badge bg-light text-dark border px-2">${item.qty} ${item.unit}</span></td>
                        <td class="text-end fw-semibold text-primary">Rp ${formatNumber(subtotal)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-remove" data-index="${index}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </td>
                    `;
                    cartTableBody.appendChild(row);

                    // Buat hidden inputs untuk form submission
                    cartHiddenInputs.innerHTML += `
                        <input type="hidden" name="items[${index}][medicine_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `;
                });
            }

            totalItemsDisplay.textContent = totalItems;
            totalPriceDisplay.textContent = 'Rp ' + formatNumber(totalPrice);
            totalAmountInput.value = totalPrice;
            
            calculateChange();
        }

        // Hapus item dari keranjang
        cartTableBody.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-remove');
            if (btn) {
                const index = btn.dataset.index;
                cart.splice(index, 1);
                renderCart();
            }
        });

        // Hitung Kembalian
        cashReceived.addEventListener('input', calculateChange);

        function calculateChange() {
            const total = parseFloat(totalAmountInput.value) || 0;
            const cash = parseFloat(cashReceived.value) || 0;
            const change = cash - total;

            if (cash > 0 && change >= 0) {
                changeDisplay.textContent = 'Rp ' + formatNumber(change);
                changeDisplay.className = 'fw-bold fs-5 text-success';
            } else if (cash > 0 && change < 0) {
                changeDisplay.textContent = 'Kurang Rp ' + formatNumber(Math.abs(change));
                changeDisplay.className = 'fw-bold fs-5 text-danger';
            } else {
                changeDisplay.textContent = 'Rp 0';
                changeDisplay.className = 'fw-bold fs-5 text-primary';
            }
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Submit form (Checkout)
        btnCheckout.addEventListener('click', function() {
            const total = parseFloat(totalAmountInput.value) || 0;
            const cash = parseFloat(cashReceived.value) || 0;
            const paymentMethod = document.querySelector('select[name="payment_method"]').value;

            if (paymentMethod === 'cash' && cash < total) {
                Swal.fire('Pembayaran Kurang', 'Jumlah uang diterima lebih kecil dari total belanja.', 'error');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembayaran?',
                text: "Transaksi akan disimpan dan stok obat akan dikurangi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Proses Penjualan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('checkoutForm').submit();
                }
            });
        });
    });
</script>
@endpush
