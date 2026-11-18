@extends('errors.layout')

@section('code', isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : '500')
@section('icon', 'fa-screwdriver-wrench')
@section('title', 'Terjadi Kesalahan Server')
@section('message', 'Maaf, terjadi masalah di sisi kami. Silakan coba lagi beberapa saat lagi.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
