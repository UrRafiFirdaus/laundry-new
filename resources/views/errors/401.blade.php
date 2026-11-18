@extends('errors.layout')

@section('code', '401')
@section('icon', 'fa-lock')
@section('title', 'Perlu Login')
@section('message', 'Anda harus masuk terlebih dahulu untuk mengakses halaman ini.')

@section('actions')
    <a href="{{ \Illuminate\Support\Facades\Route::has('login') ? route('login') : url('/') }}" class="err-btn primary"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
    <a href="{{ url('/') }}" class="err-btn ghost"><i class="fa-solid fa-house"></i> Ke Beranda</a>
@endsection
