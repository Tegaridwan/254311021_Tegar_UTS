@extends('layouts.penjual')
@section('title', 'Dashboard')

@section('isi')
@php
    $ulasanList = $penjual?->ulasan ?? collect();
@endphp

<h1 class="text-3xl font-bold mb-1.5">Dashboard</h1>
<p class="text-sm text-[#6b7385] mb-7">Ringkasan aktivitas toko dan ulasan terbaru.</p>

@if(session('success'))
    <div class="px-4 py-3 rounded-[10px] mb-5 text-sm bg-[#e6f6ed] text-[#22a35a]">{{ session('success') }}</div>
@endif

@if(!$penjual)
    <div class="max-w-[520px] border border-[#ffc107] bg-[#fff3cd] rounded-[24px] p-6">
        <h3 class="text-lg font-bold mb-1">Data Toko Belum Lengkap</h3>
        <p class="text-sm mb-4">Silakan lengkapi informasi toko Anda terlebih dahulu.</p>
        <a href="{{ route('penjual.edit') }}" class="inline-block px-5 py-2.5 rounded-lg font-bold bg-[#2878eb] text-white">Lengkapi Data Sekarang</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="border border-[#dde1ea] rounded-[28px] p-6">
            <small class="text-[13px] text-[#6b7385]">Total Ulasan</small>
            <h2 class="text-4xl font-bold mt-3.5 mb-2.5">{{ $ulasanList->count() }}</h2>
        </div>
        <div class="border border-[#dde1ea] rounded-[28px] p-6">
            <small class="text-[13px] text-[#6b7385]">Rata-rata Rating</small>
            <h2 class="text-4xl font-bold mt-3.5 mb-2.5">{{ number_format($ulasanList->avg('Rating') ?? 0, 1) }}</h2>
            <span class="text-[#f5a623]">{{ str_repeat('★', (int) round($ulasanList->avg('Rating') ?? 0)) }}</span>
        </div>
        <div class="border border-[#dde1ea] rounded-[28px] p-6">
            <small class="text-[13px] text-[#6b7385]">Ulasan Bintang 5</small>
            <h2 class="text-4xl font-bold mt-3.5 mb-2.5">{{ $ulasanList->where('Rating', 5)->count() }}</h2>
        </div>
    </div>

    <div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white mb-6">
        <h2 class="text-[22px] font-bold mb-4">Informasi Toko Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-6 text-sm">
            <div><small class="block text-xs font-bold text-[#6b7385] mb-2">Nama Toko</small>{{ $penjual->Nama_Penjual }}</div>
            <div><small class="block text-xs font-bold text-[#6b7385] mb-2">Alamat</small>{{ $penjual->Alamat_Penjual }}</div>
            <div><small class="block text-xs font-bold text-[#6b7385] mb-2">No. Telepon</small>{{ $penjual->No_Telp_Penjual }}</div>
            <div><small class="block text-xs font-bold text-[#6b7385] mb-2">Deskripsi</small>{{ $penjual->Deskripsi ?? '-' }}</div>
        </div>
        <a href="{{ route('penjual.edit') }}" class="inline-block mt-6 px-5 py-2.5 rounded-lg font-bold bg-[#2878eb] text-white">Edit Data Toko</a>
    </div>

    <div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white">
        <h2 class="text-[22px] font-bold mb-4">Ulasan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <tbody>
                @forelse($ulasanList->sortByDesc('created_at')->take(4) as $u)
                    <tr>
                        <td class="px-3 py-5 border-t border-[#dde1ea] font-bold">{{ $u->Nama_Pembeli }}</td>
                        <td class="px-3 py-5 border-t border-[#dde1ea] text-[#f5a623]">{{ str_repeat('★', $u->Rating) }}</td>
                        <td class="px-3 py-5 border-t border-[#dde1ea]">{{ $u->Ulasan }}</td>
                        <td class="px-3 py-5 border-t border-[#dde1ea] text-right text-[#6b7385]">{{ $u->created_at?->locale('id')->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td class="py-8 text-center text-[#6b7385]">Belum ada ulasan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection