<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Room;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardRentController extends Controller
{
    /**
     * Menampilkan halaman dashboard peminjaman untuk admin.
     */
    public function index()
    {
        return view('dashboard.rents.index', [
            'adminRents' => Rent::latest()->paginate(10),
            'title' => "Kelola Peminjaman",
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Logika persetujuan/penolakan dan notifikasi sudah dipindahkan ke TemporaryRentController.
     * Method ini bisa dikosongkan atau digunakan untuk fungsi update lain jika ada.
     */
    public function update(Request $request, Rent $rent)
    {
        // Logika utama untuk persetujuan sudah dipindahkan ke TemporaryRentController.
        // Method ini dibiarkan agar tidak menyebabkan error pada Route::resource.
        return redirect('/dashboard/rents')->with('info', 'Aksi tidak terdefinisi.');
    }

    /**
     * Menyimpan data peminjaman baru yang diajukan.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required',
            'time_start_use' => 'required|date|after_or_equal:now',
            'time_end_use' => 'required|date|after:time_start_use',
            'purpose' => 'required|max:250',
        ]);

        $newStartTime = $request->time_start_use;
        $newEndTime = $request->time_end_use;

        $existingRent = Rent::where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->where(function ($query) use ($newStartTime, $newEndTime) {
                $query->where('time_start_use', '<', $newEndTime)
                      ->where('time_end_use', '>', $newStartTime);
            })
            ->exists();

        if ($existingRent) {
            return back()->withErrors([
                'time_start_use' => 'Jadwal pada jam ini sudah terisi atau sedang menunggu persetujuan. Silakan pilih waktu yang berbeda.'
            ])->withInput();
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['transaction_start'] = now();
        $validatedData['status'] = 'pending';
        $validatedData['transaction_end'] = null;

        Rent::create($validatedData);

        if (auth()->user()->role_id === 1) {
            return redirect('/dashboard/rents')->with('rentSuccess', 'Peminjaman berhasil diajukan.');
        } elseif (auth()->user()->role_id === 2) {
            return redirect('/daftarpinjam')->with('rentSuccess', 'Peminjaman diajukan. Harap tunggu konfirmasi admin.');
        }
    }

    /**
     * Menghapus data peminjaman.
     */
    public function destroy(Rent $rent)
    {
        Rent::destroy($rent->id);
        return redirect('/dashboard/rents')->with('deleteRent', 'Data peminjaman berhasil dihapus');
    }

    /**
     * Menandai transaksi telah selesai.
     */
    public function endTransaction($id)
    {
        $transaction = [
            'transaction_end' => now(),
            'status' => 'selesai',
        ];
        Rent::where('id', $id)->update($transaction);
        return redirect('/dashboard/rents');
    }

    /**
     * Mencetak semua data peminjaman.
     */
    public function print()
    {
        $adminRents = Rent::with(['user', 'room'])->latest()->get();
        return view('dashboard.rents.print', compact('adminRents'));
    }
}
