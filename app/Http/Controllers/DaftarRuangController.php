<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Rent;
use App\Models\Building;
use Carbon\Carbon;

class DaftarRuangController extends Controller
{
    /**
     * Menampilkan halaman daftar semua ruangan.
     * Logika status ruangan ada di sini.
     */
    public function index()
    {
        // Mengambil waktu saat ini untuk perbandingan
        $now = Carbon::now();

        // Mengambil semua ruangan dengan paginasi (seperti kode Anda)
        $rooms = Room::orderBy('created_at', 'desc')->paginate(6);

        // Untuk setiap ruangan yang akan ditampilkan, kita tambahkan properti status
        foreach ($rooms as $room) {
            // Cek ke tabel 'rents' apakah ada peminjaman yang aktif untuk ruangan ini
            $isBooked = Rent::where('room_id', $room->id)
                            ->where('status', 'dipinjam') // Pastikan status ini benar
                            ->where('time_start_use', '<=', $now)
                            ->where('time_end_use', '>=', $now)
                            ->exists(); // 'exists()' lebih efisien untuk sekadar cek keberadaan

            // Tambahkan properti baru ke objek $room berdasarkan hasil pengecekan
            if ($isBooked) {
                $room->status_display = 'Sedang Dipinjam';
                $room->status_class = 'status-dipinjam';
            } else {
                $room->status_display = 'Kosong';
                $room->status_class = 'status-kosong';
            }
        }

        // Kirim data ke view. Variabel $bookedRoomIds sudah tidak kita perlukan lagi
        // karena statusnya sudah menempel di setiap $room.
        return view('daftarruang', [
            'title' => "Daftar Ruang",
            'rooms' => $rooms, // $rooms ini sudah berisi info status
            'buildings' => Building::all(),
        ]);
    }


    /**
     * Menampilkan halaman detail untuk satu ruangan.
     * Method ini sudah benar, tidak perlu diubah untuk tugas kita.
     */
    public function show(Room $room)
    {
        // --- LOGIKA UNTUK HALAMAN DETAIL SATU RUANGAN ---
        $now = Carbon::now();
        $isCurrentlyBooked = Rent::where('room_id', $room->id)
            ->where('status', 'Disetujui')
            ->where('time_start_use', '<=', $now)
            ->where('time_end_use', '>=', $now)
            ->exists();

        return view('showruang', [
            'title' => $room->name,
            'room' => $room,
            'rooms' => Room::all(), // Ini mungkin bisa dihapus jika tidak dipakai di view 'showruang'
            'rents' => Rent::where('room_id', $room->id)->latest()->paginate(5),
            'isCurrentlyBooked' => $isCurrentlyBooked,
        ]);
    }
}