<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Public: Simpan pengaduan dari form publik
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'category' => 'required|string|max:100',
            'message' => 'required|string|min:10',
        ]);

        Complaint::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'category' => $request->category,
            'message' => $request->message,
            'status' => 'baru',
        ]);

        return response()->json(['success' => true, 'message' => 'Pengaduan berhasil dikirim!']);
    }

    /**
     * Admin: Daftar semua pengaduan
     */
    public function index()
    {
        $complaints = Complaint::orderBy('created_at', 'desc')->get();
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Admin: Detail & Respon pengaduan
     */
    public function show(Complaint $complaint)
    {
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Admin: Update status & respon
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
            'admin_response' => 'nullable|string',
        ]);

        $complaint->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        return redirect()->route('complaints.index')->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    /**
     * Admin: Hapus pengaduan
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
