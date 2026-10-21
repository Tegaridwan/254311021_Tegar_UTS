<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanUlasan extends Model
{
    protected $table = 'laporan_ulasans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Id_Ulasan',
        'Alasan',
    ];

    // Relasi ke tabel ulasan
    public function ulasan()
    {
        return $this->belongsTo(ulasan::class, 'Id_Ulasan', 'Id_Ulasan');
    }
}
