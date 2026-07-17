<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Room;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::with('rooms')->orderBy('building')->orderBy('floor')->orderBy('name')->get();
        return view('wards.index', compact('wards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building' => 'required|string|max:255',
            'floor' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1',
        ]);

        Ward::create($request->all());

        return redirect()->route('wards.index')->with('success', 'Data Bangsal berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'building' => 'required|string|max:255',
            'floor' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1',
        ]);

        $ward = Ward::findOrFail($id);
        $ward->update($request->all());

        // Sinkronisasi nama gedung/lantai/bangsal ke semua kamar terkait
        $ward->rooms()->update([
            'building' => $ward->building,
            'floor' => $ward->floor,
            'name' => $ward->name,
        ]);

        return redirect()->route('wards.index')->with('success', 'Data Bangsal berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $ward = Ward::findOrFail($id);

        // Cek apakah ada kamar yang masih terisi pasien
        $occupiedRooms = $ward->rooms()->where('occupied_beds', '>', 0)->count();
        if ($occupiedRooms > 0) {
            return redirect()->route('wards.index')
                ->with('error', 'Tidak bisa menghapus bangsal ini! Masih ada kamar yang terisi pasien.');
        }

        // Hapus semua kamar terkait, lalu hapus bangsal
        $ward->rooms()->delete();
        $ward->delete();

        return redirect()->route('wards.index')->with('success', 'Data Bangsal berhasil dihapus.');
    }

    /**
     * Tambah kamar/kelas baru di dalam bangsal (dipanggil dari halaman Master Bangsal)
     */
    public function addRoom(Request $request, Ward $ward)
    {
        $request->validate([
            'room_class' => 'required|string|max:50',
            'total_beds' => 'required|integer|min:1',
        ]);

        // Validasi: total bed semua kamar + bed baru tidak boleh melebihi max_capacity
        $currentTotalBeds = $ward->rooms()->sum('total_beds');
        if (($currentTotalBeds + $request->total_beds) > $ward->max_capacity) {
            $sisa = $ward->max_capacity - $currentTotalBeds;
            return redirect()->route('wards.index')
                ->with('error', "Gagal! Total bed ({$currentTotalBeds} + {$request->total_beds} = " . ($currentTotalBeds + $request->total_beds) . ") melebihi kapasitas maksimal bangsal ({$ward->max_capacity} bed). Sisa kapasitas: {$sisa} bed.");
        }

        Room::create([
            'ward_id' => $ward->id,
            'building' => $ward->building,
            'floor' => $ward->floor,
            'name' => $ward->name,
            'room_class' => $request->room_class,
            'total_beds' => $request->total_beds,
            'occupied_beds' => 0,
        ]);

        return redirect()->route('wards.index')
            ->with('success', "Kamar kelas {$request->room_class} ({$request->total_beds} bed) berhasil ditambahkan ke Bangsal {$ward->name}.");
    }

    /**
     * Hapus kamar dari bangsal
     */
    public function removeRoom(Ward $ward, Room $room)
    {
        if ($room->occupied_beds > 0) {
            return redirect()->route('wards.index')
                ->with('error', 'Tidak bisa menghapus kamar ini! Masih ada pasien yang dirawat.');
        }

        $room->delete();

        return redirect()->route('wards.index')
            ->with('success', "Kamar kelas {$room->room_class} berhasil dihapus dari Bangsal {$ward->name}.");
    }
}
