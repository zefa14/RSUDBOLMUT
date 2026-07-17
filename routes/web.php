<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\DashboardController;

// Public Frontend Routes
Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('home');
Route::get('/daftar-online', [App\Http\Controllers\FrontendController::class, 'registerForm'])->name('frontend.register');
Route::post('/daftar-online', [App\Http\Controllers\FrontendController::class, 'submitRegistration'])->name('frontend.register.submit');
Route::get('/get-doctors/{department_id}', [App\Http\Controllers\FrontendController::class, 'getDoctors']);
Route::post('/pengaduan', [App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store');
Route::post('/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Harus Login)
Route::middleware('auth')->group(function () {
    
    // Semua user login bisa akses profil
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    

    // Rute Super Admin Khusus
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('wards', App\Http\Controllers\WardController::class)->except(['create', 'show', 'edit']);
    });

    // Super Admin & Admin: Kelola kamar di dalam bangsal
    Route::middleware('role:super_admin,admin,petugas')->group(function () {
        Route::post('/wards/{ward}/rooms', [App\Http\Controllers\WardController::class, 'addRoom'])->name('wards.addRoom');
        Route::delete('/wards/{ward}/rooms/{room}', [App\Http\Controllers\WardController::class, 'removeRoom'])->name('wards.removeRoom');
    });

    // Rute Admin & Petugas & Dokter & Kasir & Farmasi
    Route::middleware('role:admin,petugas,doctor,kasir,farmasi')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Rute Admin & Petugas
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('doctors', DoctorController::class);
        Route::get('doctors/{doctor}/schedules', [App\Http\Controllers\DoctorController::class, 'schedules'])->name('doctors.schedules');
        Route::post('doctors/{doctor}/schedules', [App\Http\Controllers\DoctorController::class, 'storeSchedules'])->name('doctors.storeSchedules');
        Route::resource('departments', DepartmentController::class);
        Route::resource('registrations', RegistrationController::class);

        // Rooms / Bed Management Routes (Admin hanya bisa lihat & update keterisian saja)
        Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
        Route::post('/rooms/{room}/occupancy', [App\Http\Controllers\RoomController::class, 'updateOccupancy'])->name('rooms.occupancy');

        // Inpatients Routes
        Route::resource('inpatients', App\Http\Controllers\InpatientController::class);
        Route::post('/inpatients/{inpatient}/discharge', [App\Http\Controllers\InpatientController::class, 'discharge'])->name('inpatients.discharge');
    });

    // Rute Farmasi, Admin & Petugas (Akses data obat, supplier, PO)
    Route::middleware('role:admin,petugas,farmasi')->group(function () {
        // Purchase Order Routes
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::post('/purchase-orders/{purchaseOrder}/confirm', [PurchaseOrderController::class, 'confirm'])->name('purchase-orders.confirm');
        Route::post('/purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');

        // Medicine & Supplier Routes
        Route::resource('medicines', MedicineController::class);
        Route::resource('suppliers', SupplierController::class);
    });

    // Rute Payment, Kasir & Farmasi (Bisa diakses Admin, Petugas, Kasir, Farmasi)
    Route::middleware('role:admin,petugas,kasir,farmasi')->group(function () {
        // Pharmacy Routes
        Route::get('/pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
        Route::get('/pharmacy/transaction-resep', [PharmacyController::class, 'transactionResep'])->name('pharmacy.transaction-resep');
        Route::post('/pharmacy/process-resep/{id}', [PharmacyController::class, 'processResep'])->name('pharmacy.process-resep');
        Route::get('/pharmacy/penjualan-bebas', [PharmacyController::class, 'penjualanBebas'])->name('pharmacy.penjualan-bebas');
        Route::post('/pharmacy/process-penjualan-bebas', [PharmacyController::class, 'processPenjualanBebas'])->name('pharmacy.process-penjualan-bebas');
        Route::get('/pharmacy/pembuatan-po', [PharmacyController::class, 'pembuatanPO'])->name('pharmacy.pembuatan-po');
        Route::get('/pharmacy/penerimaan', [PharmacyController::class, 'penerimaan'])->name('pharmacy.penerimaan');
        Route::get('/pharmacy/mutasi-barang', [PharmacyController::class, 'mutasiBarang'])->name('pharmacy.mutasi-barang');
        Route::get('/pharmacy/stock-barang', [PharmacyController::class, 'stockBarang'])->name('pharmacy.stock-barang');
    });

    // Rute khusus Kasir & Pembayaran (Admin, Petugas, Kasir)
    Route::middleware('role:admin,petugas,kasir')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/draft/{registration}', [PaymentController::class, 'createDraft'])->name('payments.createDraft');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/process', [PaymentController::class, 'process'])->name('payments.process');
    });

    // Rute khusus rekam medis (Dokter & Admin)
    Route::middleware('role:admin,doctor')->group(function () {
        Route::get('/get-active-registration/{patient_id}', [App\Http\Controllers\MedicalRecordController::class, 'getActiveRegistration']);
        Route::resource('medical_records', MedicalRecordController::class);
    });

    // Rute khusus Admin
    Route::middleware('role:admin')->group(function () {
        // Report Routes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Setting Routes
        Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

        // Complaint / Pengaduan Routes (Admin)
        Route::get('/complaints', [App\Http\Controllers\ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [App\Http\Controllers\ComplaintController::class, 'show'])->name('complaints.show');
        Route::put('/complaints/{complaint}', [App\Http\Controllers\ComplaintController::class, 'update'])->name('complaints.update');
        Route::delete('/complaints/{complaint}', [App\Http\Controllers\ComplaintController::class, 'destroy'])->name('complaints.destroy');
    });
});