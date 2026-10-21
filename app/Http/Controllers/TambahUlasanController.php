<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ulasan;

class TambahUlasanController extends Controller
{
    public function index()
    {
        return view('tambah-ulasan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Id_Penjual' => 'required|exists:penjual,Id_Penjual',
            'Nama_Pembeli' => 'required|string|max:255',
            'Ulasan' => 'required|string',
            'foto_ulasan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Rating' => 'required|integer|min:1|max:5',
        ]);

       

        ulasan::create([
            'Id_Penjual' => $validatedData['Id_Penjual'],
            'Nama_Pembeli' => $validatedData['Nama_Pembeli'],
            'Ulasan' => $validatedData['Ulasan'],
            'foto_ulasan' => $request->hasFile('foto_ulasan') ? $request->file('foto_ulasan')->store('ulasan_fotos', 'public') : null,
            'Rating' => $validatedData['Rating'],
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    public function destroy($id){
        $ulasan = ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
