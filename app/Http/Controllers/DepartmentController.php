<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('doctors')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0'
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Data Poliklinik berhasil ditambahkan!');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0'
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Data Poliklinik berhasil diperbarui!');
    }

    public function destroy(Department $department)
    {
        // Cek jika poli masih memiliki dokter
        if ($department->doctors()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Tidak bisa menghapus Poliklinik yang masih memiliki Dokter!');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Data Poliklinik berhasil dihapus!');
    }
}