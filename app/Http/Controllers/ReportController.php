<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default: Laporan Pendapatan Bulan Ini
        $reportType = $request->input('type', 'revenue');
        
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = [];
        $totalSum = 0;
        $subStat = 0; // Metrik Tambahan
        $chartLabels = [];
        $chartData = [];

        if ($reportType == 'revenue') {
            // Laporan Pendapatan (Kasir)
            $query = Payment::with(['registration.patient', 'processor'])
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            
            $data = $query->latest('paid_at')->get();
            $totalSum = $data->sum('total_amount');
            $subStat = $data->count(); // Total Transaksi Lunas

            // Data untuk Chart (Dikelompokkan per hari)
            $grouped = $data->groupBy(function($item) {
                return Carbon::parse($item->paid_at)->format('Y-m-d');
            });
            foreach($grouped as $date => $items) {
                $chartLabels[] = \Carbon\Carbon::parse($date)->format('d M');
                $chartData[] = $items->sum('total_amount');
            }

        } elseif ($reportType == 'visits') {
            // Laporan Kunjungan Pasien
            $query = Registration::with(['patient', 'doctor', 'department'])
                ->whereBetween('registration_date', [$startDate, $endDate]);

            // Filter status jika perlu, sementara ambil semua
            $data = $query->orderBy('registration_date', 'asc')->get();
            $totalSum = $data->count(); // Total kunjungan
            $subStat = $data->unique('patient_id')->count(); // Pasien unik

            // Data untuk Chart (Dikelompokkan per hari)
            $grouped = $data->groupBy(function($item) {
                return Carbon::parse($item->registration_date)->format('Y-m-d');
            });
            foreach($grouped as $date => $items) {
                $chartLabels[] = \Carbon\Carbon::parse($date)->format('d M');
                $chartData[] = $items->count();
            }
        }

        // Urutkan berdasarkan tanggal (agar urutan grafiknya maju)
        if(count($chartLabels) > 0) {
            $sortedData = [];
            foreach($chartLabels as $key => $label) {
                $sortedData[$label] = $chartData[$key];
            }
            ksort($sortedData); // ini hanya sort berdasarkan string 'd M', untuk fixnya pakai datetime sort
        }

        return view('reports.index', compact('reportType', 'startDate', 'endDate', 'data', 'totalSum', 'subStat', 'chartLabels', 'chartData'));
    }
}
