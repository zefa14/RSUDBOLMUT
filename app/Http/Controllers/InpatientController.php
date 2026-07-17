<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Doctor;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InpatientController extends Controller
{
    public function index()
    {
        $inpatients = Inpatient::with(['patient', 'room', 'doctor'])
            ->where('status', 'admitted')
            ->orderBy('admission_date', 'desc')
            ->paginate(15);
            
        $discharged = Inpatient::with(['patient', 'room', 'doctor'])
            ->where('status', 'discharged')
            ->orderBy('discharge_date', 'desc')
            ->paginate(15, ['*'], 'discharged_page');
            
        return view('inpatients.index', compact('inpatients', 'discharged'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        // Hanya kamar yang belum penuh
        $rooms = Room::whereRaw('occupied_beds < total_beds')->orderBy('name')->get();
        
        return view('inpatients.create', compact('patients', 'doctors', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $room = Room::findOrFail($request->room_id);
            if ($room->occupied_beds >= $room->total_beds) {
                return back()->withInput()->with('error', 'Kamar sudah penuh.');
            }

            Inpatient::create([
                'patient_id' => $request->patient_id,
                'room_id' => $request->room_id,
                'doctor_id' => $request->doctor_id,
                'admission_date' => $request->admission_date,
                'status' => 'admitted',
                'notes' => $request->notes,
            ]);

            $room->increment('occupied_beds');

            DB::commit();
            return redirect()->route('inpatients.index')->with('success', 'Pasien berhasil didaftarkan rawat inap.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mendaftar rawat inap: ' . $e->getMessage());
        }
    }

    public function show(Inpatient $inpatient)
    {
        $inpatient->load(['patient', 'room', 'doctor']);
        return view('inpatients.show', compact('inpatient'));
    }

    public function discharge(Request $request, Inpatient $inpatient)
    {
        if ($inpatient->status === 'discharged') {
            return back()->with('error', 'Pasien sudah dipulangkan sebelumnya.');
        }

        $request->validate([
            'discharge_date' => 'required|date|after_or_equal:admission_date',
        ]);

        DB::beginTransaction();
        try {
            $inpatient->update([
                'discharge_date' => $request->discharge_date,
                'status' => 'discharged',
            ]);

            $inpatient->room->decrement('occupied_beds');

            // Hitung tagihan rawat inap
            $admission = Carbon::parse($inpatient->admission_date)->startOfDay();
            $discharge = Carbon::parse($inpatient->discharge_date)->startOfDay();
            $days = $discharge->diffInDays($admission);
            if ($days == 0) $days = 1; // Minimal 1 hari

            $price_per_night = $inpatient->room->price_per_night ?? 0;
            $subtotal = $days * $price_per_night;

            $payment = Payment::create([
                'payment_type' => 'inpatient',
                'patient_id' => $inpatient->patient_id,
                'invoice_number' => 'INV-INP-' . time() . '-' . rand(10,99),
                'total_amount' => $subtotal,
                'status' => 'pending',
                'notes' => 'Tagihan Rawat Inap ' . $inpatient->room->name . ' (' . $days . ' hari)',
            ]);

            $payment->items()->create([
                'description' => 'Biaya Kamar ' . $inpatient->room->name . ' (' . $inpatient->room->room_class . ') x ' . $days . ' Hari',
                'quantity' => $days,
                'price' => $price_per_night,
            ]);

            DB::commit();
            return redirect()->route('inpatients.index')->with('success', 'Pasien berhasil dipulangkan. Draft tagihan telah terbit ke kasir.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulangkan pasien: ' . $e->getMessage());
        }
    }
}
