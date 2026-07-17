<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::with('category')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $medicines = $query->paginate(15)->withQueryString();
        $totalMedicines = Medicine::count();

        return view('medicines.index', compact('medicines', 'totalMedicines'));
    }

    public function create()
    {
        $categories = MedicineCategory::orderBy('name')->get();
        return view('medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medicines,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:medicine_categories,id',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');

        Medicine::create($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Data Obat berhasil ditambahkan!');
    }

    public function edit(Medicine $medicine)
    {
        $categories = MedicineCategory::orderBy('name')->get();
        return view('medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medicines,code,' . $medicine->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:medicine_categories,id',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');

        $medicine->update($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Data Obat berhasil diperbarui!');
    }

    public function destroy(Medicine $medicine)
    {
        // Ganti status jadi tidak aktif daripada delete permanen, karena mungkin sudah dipakai di resep/transaksi
        $medicine->update(['active' => false]);

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil di-nonaktifkan (dihapus dari daftar aktif).');
    }
}
