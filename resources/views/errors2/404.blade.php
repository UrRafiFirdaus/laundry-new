@includeIf('landing.header')

@extends('landing.master')


@section('content')
<div class="container text-center py-5">
    
    <h3>Halaman Tidak Ditemukan</h3>
    <p>Maaf, halaman yang Anda cari tidak tersedia.</p>

    <a href="{{ url('/') }}" class="btn btn-primary">
        Kembali ke Beranda
    </a>
</div>
@endsection