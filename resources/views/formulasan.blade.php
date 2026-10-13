@extends('layouts.app')
@section('title', 'Beri Ulasan')

@section('content')
<div class="max-w-[520px] mx-auto px-5 py-10">
    <h1 class="text-3xl font-bold mb-1.5">Beri Ulasan</h1>
    <p class="text-sm text-[#6b7385] mb-7">Untuk <b>{{ $penjual->Nama_Penjual }}</b>. Tidak perlu login.</p>

    @include('form-ulasan')

    <p class="mt-5 text-sm">
        <a href="{{ route('penjual.detail', $penjual->Id_Penjual) }}" class="text-[#6b7385]">← Kembali ke detail penjual</a>
        <span class="text-[#6b7385]"> | </span>
        <a href="{{ route('dashboard') }}" class="text-[#6b7385]">Kembali ke beranda</a>
    </p>
</div>
@endsection