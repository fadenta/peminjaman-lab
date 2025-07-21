<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Room;
use App\Models\Notification; // Pastikan ini ada

class TemporaryRentController extends Controller
{
    public function index()
    {
        return view('dashboard.temporaryRents.index', [
            'title' => "Daftar Peminjaman Sementara",
            'rents' => Rent::where('status', 'pending')->latest()->paginate(10),
        ]);
    }

    public function acceptRents($id)
    {
        $rent = Rent::findOrFail($id);

        // 1. Ubah status peminjaman menjadi 'dipinjam'
        $rent->update(['status' => 'dipinjam']);

        // 2. Buat notifikasi untuk pengguna
        $message = "Peminjaman ruang '" . $rent->room->name . "' Anda telah disetujui oleh Admin.";
        Notification::create([
            'user_id' => $rent->user_id,
            'message' => $message,
        ]);

        // 3. Kembalikan admin ke halaman riwayat peminjaman
        return redirect('/dashboard/rents')->with('success', 'Peminjaman telah berhasil disetujui!');
    }

    public function declineRents($id)
    {
        $rent = Rent::findOrFail($id);

        // 1. Ubah status peminjaman menjadi 'ditolak'
        $rent->update(['status' => 'ditolak']);

        // 2. Buat notifikasi untuk pengguna
        $message = "Mohon maaf, peminjaman ruang '" . $rent->room->name . "' Anda ditolak oleh Admin.";
        Notification::create([
            'user_id' => $rent->user_id,
            'message' => $message,
        ]);

        // 3. Kembalikan admin ke halaman riwayat peminjaman
        return redirect('/dashboard/rents')->with('success', 'Peminjaman telah ditolak.');
    }
}
