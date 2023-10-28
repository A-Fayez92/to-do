@extends('layouts.app')

@section('content')

<style>
    @media(prefers-color-scheme: dark) {
        .bg-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(200,200,255,0.15)'/%3E%3C/svg%3E");
        }
    }

    @media(prefers-color-scheme: light) {
        .bg-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,50,0.10)'/%3E%3C/svg%3E")
        }
    }
</style>


<div
    class="flex min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">
    @if(!auth()->check())

    <div class="max-w-6xl px-6 py-4 mx-auto text-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white md:text-5xl">{{ __("Welcome to") }} <span
                class="text-indigo-500">{{ __("Todo List") }}</span></h1>
        <p class="mt-2 md:text-lg text-sm text-gray-600 dark:text-gray-400"> {{ __('A simple todo list app built with Laravel and Tailwind CSS.') }}
        <div class="flex justify-center mt-6">
            <a href="{{ route('login') }}"
                class="px-4 py-2 mx-2 md:text-lg text-sm font-semibold text-white transition-colors duration-200 transform bg-indigo-500 rounded-md hover:bg-indigo-400 focus:outline-none focus:bg-indigo-400">{{
                __('Login') }}</a>
            <a href="{{ route('register') }}"
                class="px-4 py-2 ml-4 md:text-lg text-sm font-semibold text-indigo-500 transition-colors duration-200 transform bg-white rounded-md hover:bg-gray-100 focus:outline-none focus:bg-gray-100">{{
                __('Register') }}</a>
        </div>
    </div>
    @else
    <div class="max-w-6xl px-6 py-4 mx-auto text-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white md:text-5xl">{{ __("Welcome to") }} <span
                class="text-indigo-500">{{ __("Todo List") }}</span></h1>
        <p class="mt-2 text-base text-gray-600 dark:text-gray-400"> {{ __('A simple todo list app built with Laravel and Tailwind CSS.') }}
        <div class="flex justify-center mt-6">
            <a href="{{ route('todos') }}"
                class="px-4 py-2 text-lg font-semibold text-white transition-colors duration-200 transform bg-indigo-500 rounded-md hover:bg-indigo-400 focus:outline-none focus:bg-indigo-400">{{
                __('Go to Todo List') }}</a>
        </div>
    </div>
    @endif
</div>
@endsection