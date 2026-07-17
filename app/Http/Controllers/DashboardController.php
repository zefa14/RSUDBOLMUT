<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalDepartments = Department::count();
        $totalRegistrations = Registration::count();

        // Data Grafik 1: Tren Kunjungan Pasien per Bulan (Tahun Ini)
        $monthlyData = Registration::selectRaw('MONTH(registration_date) as month, COUNT(*) as count')
            ->whereYear('registration_date', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')->toArray();
            
        $chartKunjungan = [];
        for($i=1; $i<=12; $i++) {
            $chartKunjungan[] = $monthlyData[$i] ?? 0;
        }

        // Data Grafik 2: Rasio Kunjungan Poli
        $deptData = Registration::selectRaw('department_id, COUNT(*) as count')
            ->with('department')
            ->groupBy('department_id')
            ->get();
            
        $chartPoliLabels = [];
        $chartPoliData = [];
        foreach($deptData as $d) {
            $chartPoliLabels[] = $d->department->name ?? 'Lainnya';
            $chartPoliData[] = $d->count;
        }

        return view('dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalDepartments',
            'totalRegistrations',
            'chartKunjungan',
            'chartPoliLabels',
            'chartPoliData'
        ));
    }
}
