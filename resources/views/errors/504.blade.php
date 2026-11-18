@extends('errors.layout')

@section('code', '504')
@section('icon', 'fa-stopwatch')
@section('title', 'Gateway Timeout')
@section('message', 'Server terlalu lama merespons. Silakan coba lagi sebentar lagi.')

@section('actions')
    <a href="javascript:location.reload()" class="err-btn primary"><i class="fa-solid fa-rotate-right"></i> Muat Ulang</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
