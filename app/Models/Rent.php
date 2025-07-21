<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    // Melindungi kolom 'id' agar tidak bisa diisi secara massal
    protected $guarded = ['id'];

    // Format default untuk waktu
    protected $dates = [
        'time_start_use',
        'time_end_use',
        'transaction_start',
        'transaction_end',
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel rooms
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
