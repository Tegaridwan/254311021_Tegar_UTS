@extends('layouts.penjual')
@section('title', 'Ulasan Pelanggan')

@section('isi')
@php $ulasanList = $penjual?->ulasan ?? collect(); @endphp

<h1 class="text-3xl font-bold mb-1.5">Ulasan Pelanggan</h1>
<p class="text-sm text-[#6b7385] mb-7">Semua ulasan yang masuk ke toko.</p>

{{-- Notifikasi Sukses --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left px-3 py-2.5">Nama Pembeli</th>
                    <th class="text-left px-3 py-2.5">Rating</th>
                    <th class="text-left px-3 py-2.5">Komentar & Respon</th>
                    <th class="text-right px-3 py-2.5">Tanggal</th>
                    <th class="text-right px-3 py-2.5">Laporan</th>
                    <th class="text-right px-3 py-2.5">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($ulasanList->sortByDesc('created_at') as $u)
                <tr>
                    <!-- Nama Pembeli -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] font-medium">{{ $u->Nama_Pembeli }}</td>
                    
                    <!-- Rating Bintang -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-[#f5a623]">{{ str_repeat('★', $u->Rating) }}</td>
                    
                    <!-- Komentar & Form Respon -->
                    <td class="px-3 py-5 border-t border-[#dde1ea]">
                        <div class="mb-2">{{ $u->Ulasan }}</div>
                        <img src="{{ $u->foto_ulasan ? asset('storage/' . $u->foto_ulasan) : '' }}" alt="Foto Ulasan" class="mt-2 max-w-[100px] rounded-lg {{ $u->foto_ulasan ? '' : 'hidden' }}">
                        
                        {{-- Jika ulasan sudah direspon, tampilkan balasannya dari tabel respon. Jika belum, tampilkan form input respon --}}
                        @if($u->balasan)
                            <div class="mt-2 p-2.5 bg-gray-50 rounded-lg text-xs text-gray-700 border border-[#dde1ea]">
                                <input type="text" name="Id_Respon" value="{{ $u->balasan->Respon }}" readonly>
                            </div>
                            <button class="edit-respon-btn mt-2 text-blue-600 hover:text-blue-800 text-sm font-semibold" data-ulasan-id="{{ $u->Id_Ulasan }}">Edit Balasan</button>
                            <form action="{{ route('respon.update', $u->balasan->Id_Respon) }}" method="POST" class="mt-2 hidden" id="respon-form-{{ $u->Id_Ulasan }}">
                                @csrf
                                @method('PUT')
                                <input type="text" name="Respon" value="{{ $u->balasan->Respon }}" class="border border-[#dde1ea] rounded px-2.5 py-1.5 text-xs w-full focus:outline-none focus:border-black" required>
                                <button type="submit" class="bg-black text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-gray-800 transition mt-1">Simpan</button>
                            </form>
                            <form action="{{ route('respon.destroy', $u->balasan->Id_Respon) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus Balasan</button>
                            </form>
                        @else
                            <form action="{{ route('respon.store') }}" method="POST" class="mt-3 flex gap-2">
                                @csrf
                                <input type="hidden" name="Id_Respon" value="{{ $u->Id_Ulasan }}">
                                <input type="text" name="Respon" placeholder="Tulis balasan..." class="border border-[#dde1ea] rounded px-2.5 py-1.5 text-xs w-full focus:outline-none focus:border-black" required>
                                <button type="submit" class="bg-black text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-gray-800 transition">Kirim</button>
                            </form>
                        @endif
                    </td>
                    
                    <!-- Tanggal -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-right text-[#6b7385] whitespace-nowrap">
                        {{ $u->created_at?->format('d M Y, H:i') }}
                    </td>
                    <!-- Laporan -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-left text-xs">
                        @if($u->laporan && $u->laporan->count() > 0)
                            <div class="inline-block bg-red-50 text-red-700 px-2.5 py-1 rounded-full font-semibold border border-red-200 mb-1.5">
                                Dilaporkan ({{ $u->laporan->count() }}x)
                            </div>
                            <div class="space-y-1">
                                @foreach($u->laporan as $lap)
                                    <div class="text-[#6b7385] bg-gray-50 p-1.5 rounded border border-[#dde1ea]">
                                        <span class="font-medium text-gray-800">Alasan:</span> "{{ $lap->Alasan }}"
                                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $lap->created_at?->format('d M Y, H:i') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="inline-block bg-green-50 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold border border-green-200">
                                Bersihhh
                            </span>
                        @endif
                    </td>
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-right">
                        <form action="{{ route('ulasan.destroy', $u->Id_Ulasan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus Ulasan</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-8 text-center text-[#6b7385]">Belum ada ulasan yang masuk untuk toko Anda.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
    //form edit respon
    const editButtons = document.querySelectorAll('.edit-respon-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const ulasanId = this.dataset.ulasanId;
            const form = document.getElementById(`respon-form-${ulasanId}`);
            form.classList.toggle('hidden');
        });
    });
</script>

@endsection