@extends('errors.layout')

@section('code', '429')
@section('icon', 'fa-gauge-high')
@section('title', 'Terlalu Banyak Permintaan')
@section('message', 'Anda mengirim permintaan terlalu cepat. Tunggu beberapa saat lalu coba lagi.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
