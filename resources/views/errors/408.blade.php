@extends('errors.layout')

@section('code', '408')
@section('icon', 'fa-hourglass-half')
@section('title', 'Waktu Permintaan Habis')
@section('message', 'Server terlalu lama menunggu permintaan Anda. Periksa koneksi internet lalu coba lagi.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
