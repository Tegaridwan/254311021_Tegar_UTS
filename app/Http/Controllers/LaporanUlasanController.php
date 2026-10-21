<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanUlasan;

class LaporanUlasanController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'Id_Ulasan' => 'required|exists:ulasan,Id_Ulasan',
            'Alasan' => 'required|string|max:255',
        ]);

        LaporanUlasan::create([
            'Id_Ulasan' => $request->Id_Ulasan,
            'Alasan' => $request->Alasan,
        ]);

        return redirect()->back()->with('success', 'Laporan ulasan berhasil dikirim!');
    }
}
