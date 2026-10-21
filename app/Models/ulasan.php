<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'Id_Ulasan';

    protected $fillable = [
        'Id_Penjual',
        'Nama_Pembeli',
        'Ulasan',
        'foto_ulasan',
        'Rating',
    ];

    // Relasi ke tabel penjual
    public function penjual()
    {
        return $this->belongsTo(penjual::class, 'Id_Penjual', 'Id_Penjual');
    }

    // Relasi ke tabel respon
    public function balasan()
    {
        return $this->hasOne(Respon::class, 'Id_Respon', 'Id_Ulasan');
    }

    // Relasi ke tabel laporan ulasan
    public function laporan()
    {
        return $this->hasMany(LaporanUlasan::class, 'Id_Ulasan', 'Id_Ulasan');
    }
}