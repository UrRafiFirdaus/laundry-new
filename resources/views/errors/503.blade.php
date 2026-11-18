@extends('errors.layout')

@section('code', '503')
@section('icon', 'fa-power-off')
@section('title', 'Layanan Sedang Tidak Tersedia')
@section('message', 'Sistem sedang dalam pemeliharaan atau kelebihan beban. Silakan kembali lagi beberapa saat.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
