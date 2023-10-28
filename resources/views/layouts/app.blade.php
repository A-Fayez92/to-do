@extends('layouts.base')
@section('title', $title ?? '')
@section('body')
    @yield('content')
    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
