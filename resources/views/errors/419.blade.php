@extends('errors.layout')

@section('code', '419')
@section('icon', 'fa-clock-rotate-left')
@section('title', 'Sesi Berakhir')
@section('message', 'Sesi Anda telah kedaluwarsa. Muat ulang halaman lalu ulangi aksi Anda.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
