@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-slate-100">

    <form
        action="{{ route('password.email') }}"
        method="POST"
        class="bg-white p-8 rounded-2xl shadow w-full max-w-md">

        @csrf

        <h2 class="text-2xl font-bold mb-6 text-center">
            Forgot Password
        </h2>

        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>

        @endif

        <div class="mb-4">

            <label class="block mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <button
            type="submit"
            class="w-full bg-cyan-600 text-white py-3 rounded-xl">

            Kirim Link Reset

        </button>

    </form>

</div>

@endsection