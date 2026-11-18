@extends('errors.layout')

@section('code', '502')
@section('icon', 'fa-server')
@section('title', 'Gateway Bermasalah')
@section('message', 'Server menerima respons yang tidak valid dari layanan lain. Silakan coba lagi sebentar lagi.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
