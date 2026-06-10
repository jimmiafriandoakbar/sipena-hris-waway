@extends('layouts.admin.app_admin')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Daftar Jabatan
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Kelola data jabatan pegawai SIPENA
            </p>

        </div>

    </div>


    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- TOP -->
        <div class="p-8 border-b border-slate-100">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <!-- NAMA JABATAN -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Jabatan
                    </label>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

                        <!-- INPUT -->
                        <input name="nama_jabatan" type="text" placeholder="Masukkan nama jabatan..." class="flex-1 h-12 px-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                transition duration-200 text-sm outline-none shadow-sm">

                        <!-- BUTTON -->
                        <button type="submit" class="h-12 px-6 rounded-xl bg-blue-600 hover:bg-blue-700
                text-white text-sm font-semibold transition shadow-sm whitespace-nowrap">

                            Simpan

                        </button>

                        </form>
                    </div>

                </div>
            </div>

        </div>


        <!-- TABLE -->
        <div class="p-8">

            <!-- FILTER -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <!-- SEARCH -->
                <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

                    <!-- INPUT -->
                    <div class="relative w-full md:w-80">

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jabatan..."
                            class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                transition duration-200 text-sm outline-none shadow-sm">

                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                            <i data-lucide="search" class="w-4 h-4"></i>

                        </div>

                    </div>

                    <!-- BUTTON CARI -->
                    <button type="submit" class="h-12 px-5 rounded-xl bg-blue-600 hover:bg-blue-700
            transition text-sm font-medium text-white shadow-sm whitespace-nowrap">

                        Cari

                    </button>

                    <!-- BUTTON RESET -->
                    <a href="{{ route('admin.daftar.jabatan') }}" class="h-12 px-5 rounded-xl border border-slate-300 bg-white
            hover:bg-slate-50 transition text-sm font-medium text-slate-700
            shadow-sm inline-flex items-center justify-center whitespace-nowrap">

                        Reset

                    </a>

                </form>

            </div>


            <!-- TABLE -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                                Nama jabatan
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <!-- DATA -->
                        @foreach($jabatan as $item)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">

                                        <i data-lucide="briefcase" class="w-5 h-5 text-blue-600"></i>

                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $item->nama_jabatan }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            Jabatan SIPENA
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-3">

                                    <!-- EDIT -->
                                    <button onclick="openEditModal(
                    '{{ $item->id }}',
                    '{{ $item->nama_jabatan }}'
                )" class="h-10 px-4 rounded-xl border border-blue-500
                text-blue-600 hover:bg-blue-50 transition
                text-sm font-medium">

                                        Edit

                                    </button>

                                    <!-- HAPUS -->
                                    <form action="{{ route('admin.jabatan.delete', $item->id) }}" method="POST"
                                        class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="h-10 px-4 rounded-xl border border-red-500
                    text-red-600 hover:bg-red-50 transition
                    text-sm font-medium">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">

                <!-- INFO -->
                <p class="text-sm text-slate-500">

                    Menampilkan

                    <span class="font-semibold text-slate-700">
                        {{ $jabatan->firstItem() }}
                    </span>

                    -

                    <span class="font-semibold text-slate-700">
                        {{ $jabatan->lastItem() }}
                    </span>

                    dari

                    <span class="font-semibold text-slate-700">
                        {{ $jabatan->total() }}
                    </span>

                    data

                </p>

                <!-- PAGE -->
                <div class="flex items-center gap-2">

                    {{ $jabatan->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 bg-black/40 hidden z-50 items-center justify-center p-4">

    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-semibold text-slate-800">
                Edit jabatan
            </h2>

        </div>

        <form id="editForm" method="POST">


            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">

                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Jabatan
                    </label>

                    <input type="text" name="nama_jabatan" id="editNama"
                        class="w-full h-12 px-4 rounded-xl border border-slate-300">

                </div>

            </div>

            <div class="p-6 border-t bg-slate-50 flex justify-end gap-3">

                <button type="button" onclick="closeEditModal()" class="h-11 px-5 rounded-xl border border-slate-300">

                    Batal

                </button>

                <button class="h-11 px-5 rounded-xl bg-blue-600 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function openEditModal(id, nama) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');

        document.getElementById('editNama').value = nama;

        document.getElementById('editForm').action =
            `/admin/jabatan/update/${id}`;
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    /* GLOBAL DELETE CONFIRM */
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            if (confirm('Anda yakin menghapus data ini?')) {
                this.submit();
            }

        });

    });
</script>

@endsection