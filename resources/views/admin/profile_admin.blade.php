@extends('layouts.admin.app_admin')

@section('content')

<div class="max-w-xl mx-auto mt-10">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- HEADER -->
        <div class="p-5 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Profile Admin</h2>
            <p class="text-sm text-gray-500">Ubah password akun admin</p>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.update-password') }}" method="POST" class="p-5 space-y-4">
            @csrf

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="bg-green-50 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR -->
            @if($errors->any())
                <div class="bg-red-50 text-red-700 px-4 py-2 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- PASSWORD LAMA -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Password Lama</label>
                <input type="password" name="old_password"
                    class="w-full border px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-blue-500"
                    required>
            </div>

            <!-- PASSWORD BARU -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full border px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-blue-500"
                    required>
            </div>

            <!-- KONFIRMASI -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full border px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-blue-500"
                    required>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                    Simpan Password
                </button>
            </div>

        </form>

    </div>

</div>

@endsection