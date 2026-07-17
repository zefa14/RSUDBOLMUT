<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar kamar di Dashboard Admin (Bed Management)
     * Data dikelompokkan per bangsal — Admin hanya bisa lihat dan klik Masuk/Keluar
     */
    public function index()
    {
        $wards = Ward::with('rooms')->orderBy('building')->orderBy('floor')->orderBy('name')->get();
        return view('rooms.index', compact('wards'));
    }

    /**
     * Memperbarui keterisian kasur (Pasien Masuk / Keluar)
     */
    public function updateOccupancy(Request $request, Room $room)
    {
        $action = $request->input('action'); // 'fill' atau 'empty'

        if ($action == 'fill') {
            if ($room->occupied_beds < $room->total_beds) {
                $room->increment('occupied_beds');
                return redirect()->back()->with('success', '1 Pasien berhasil masuk ke ' . $room->name . ' (' . $room->room_class . ')');
            }
            return redirect()->back()->with('error', 'Kapasitas bed ' . $room->room_class . ' di ' . $room->name . ' sudah penuh!');
        } 
        
        if ($action == 'empty') {
            if ($room->occupied_beds > 0) {
                $room->decrement('occupied_beds');
                return redirect()->back()->with('success', '1 Pasien berhasil keluar dari ' . $room->name . ' (' . $room->room_class . ')');
            }
            return redirect()->back()->with('error', 'Ruangan ' . $room->room_class . ' di ' . $room->name . ' sudah kosong!');
        }

        return redirect()->back();
    }
}
