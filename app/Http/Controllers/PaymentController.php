<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Registration;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Tampilkan antrian kasir (Registration yang sudah selesai tapi belum dibayar)
     */
    public function index()
    {
        // Tagihan Belum Dibayar (Registration status = done, tidak ada Payment)
        $unpaidRegistrations = Registration::with(['patient', 'doctor', 'department'])
            ->whereIn('status', ['serving', 'done'])
            ->doesntHave('payment')
            ->latest('registration_date')
            ->get();

        // Draft Tagihan (Pending Payments) - dari pendaftaran atau farmasi
        $pendingPayments = Payment::with(['registration.patient', 'patient'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Riwayat Tagihan Lunas (Bulan ini)
        $paidPayments = Payment::with(['registration.patient', 'patient'])
            ->where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('unpaidRegistrations', 'pendingPayments', 'paidPayments'));
    }

    /**
     * Buat Draft Tagihan Baru (Berdasarkan Registration)
     */
    public function createDraft($registration_id)
    {
        $registration = Registration::with(['patient', 'doctor'])->findOrFail($registration_id);

        // Cari rekam medis terkait kunjungan ini
        $medicalRecord = MedicalRecord::with('prescriptions.medicine')
            ->where('patient_id', $registration->patient_id)
            ->latest('id')
            ->first();

        DB::beginTransaction();
        try {
            // Buat Payment Header
            $payment = Payment::create([
                'registration_id' => $registration->id,
                'status'          => 'pending',
                'total_amount'    => 0, // Akan dihitung ulang
            ]);

            $totalAmount = 0;

            // 1. Biaya Konsultasi Dokter (Hierarki: Dokter -> Poli -> Global)
            $feeDokter = 0;

            if ($registration->doctor && $registration->doctor->consultation_fee !== null) {
                // Prioritas 1: Tarif khusus Dokter
                $feeDokter = $registration->doctor->consultation_fee;
            } elseif ($registration->department && $registration->department->consultation_fee !== null) {
                // Prioritas 2: Tarif default Poli
                $feeDokter = $registration->department->consultation_fee;
            } else {
                // Prioritas 3: Tarif Global di Pengaturan Web
                $settingsJson = \Illuminate\Support\Facades\Storage::get('settings.json');
                $settings = $settingsJson ? json_decode($settingsJson, true) : [];
                
                $feeUmum = isset($settings['fee_dokter_umum']) && $settings['fee_dokter_umum'] != '' ? (int)$settings['fee_dokter_umum'] : 150000;
                $feeSpesialis = isset($settings['fee_dokter_spesialis']) && $settings['fee_dokter_spesialis'] != '' ? (int)$settings['fee_dokter_spesialis'] : 200000;

                $feeDokter = $feeUmum;
                if (str_contains(strtolower($registration->department->name ?? ''), 'spesialis')) {
                    $feeDokter = $feeSpesialis;
                }
            }

            PaymentItem::create([
                'payment_id'  => $payment->id,
                'description' => 'Biaya Konsultasi ' . $registration->doctor->name,
                'quantity'    => 1,
                'price'       => $feeDokter,
                'subtotal'    => $feeDokter,
            ]);
            $totalAmount += $feeDokter;

            // 2. Biaya Obat (jika ada resep)
            if ($medicalRecord && $medicalRecord->prescriptions->count() > 0) {
                foreach ($medicalRecord->prescriptions as $resep) {
                    $harga = $resep->medicine->price ?? 0;
                    $subtotalObat = $harga * $resep->quantity;

                    PaymentItem::create([
                        'payment_id'  => $payment->id,
                        'description' => 'Obat: ' . ($resep->medicine->name ?? 'Unknown'),
                        'quantity'    => $resep->quantity,
                        'price'       => $harga,
                        'subtotal'    => $subtotalObat,
                    ]);
                    $totalAmount += $subtotalObat;
                }
            }

            // Update Total
            $payment->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('payments.show', $payment->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat draft tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan rincian tagihan (Form Kasir)
     */
    public function show($id)
    {
        $payment = Payment::with(['registration.patient', 'registration.doctor', 'items'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    /**
     * Proses pelunasan tagihan
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bpjs,insurance,transfer,debit,credit',
            'cash_received'  => 'nullable|numeric|min:0',
        ]);

        $payment = Payment::findOrFail($id);

        if ($request->payment_method == 'cash') {
            if ($request->cash_received < $payment->total_amount) {
                return back()->with('error', 'Jumlah uang tunai kurang dari total tagihan.');
            }
        }

        $payment->update([
            'payment_method' => $request->payment_method,
            'status'         => 'paid',
            'paid_at'        => now(),
            'processed_by'   => auth()->id(),
            'notes'          => $request->notes,
        ]);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil diproses dan lunas!');
    }
}
