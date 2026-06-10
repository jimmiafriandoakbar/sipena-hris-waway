@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-slate-100">

    <form
        method="POST"
        action="{{ route('password.store') }}"
        class="bg-white p-8 rounded-2xl shadow w-full max-w-md">

        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ request()->route('token') }}">

        <h2 class="text-2xl font-bold mb-6 text-center">
            Reset Password
        </h2>

        <div class="mb-4">

            <label class="block mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ request()->email }}"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Password Baru
            </label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <div class="mb-6">

            <label class="block mb-2">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <button
            type="submit"
            class="w-full bg-cyan-600 text-white py-3 rounded-xl">

            Reset Password

        </button>

    </form>

</div>

@endsection