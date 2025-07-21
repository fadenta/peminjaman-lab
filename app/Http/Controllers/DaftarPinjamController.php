<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Room;

class DaftarPinjamController extends Controller
{
    public function index()
{
    $userId = auth()->user()->id;

    // Ambil peminjaman terbaru yang disetujui hari ini
    $latestApproved = Rent::where('user_id', $userId)
        ->where('status', 'dipinjam')
        ->whereDate('updated_at', today()) // notifikasi hanya muncul jika disetujui hari ini
        ->latest()
        ->first();

    if ($latestApproved) {
        session()->flash('approvalSuccess', 'Peminjaman Anda telah disetujui oleh admin!');
    }

    return view('daftarpinjam', [
        'userRents' => Rent::where('user_id', $userId)->latest()->paginate(5),
        'title' => "Daftar Pinjam",
        'rooms' => Room::all(),
    ]);
}

}
