@extends('errors.layout')

@section('code', isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : '400')
@section('icon', 'fa-circle-exclamation')
@section('title', 'Permintaan Tidak Dapat Diproses')
@section('message', 'Terjadi masalah pada permintaan Anda. Silakan kembali dan coba lagi.')
