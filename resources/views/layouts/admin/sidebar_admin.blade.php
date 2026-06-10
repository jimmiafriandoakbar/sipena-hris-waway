<aside class="w-64 h-screen bg-slate-900 text-white fixed">

    <!-- LOGO -->
    <div class="p-5 text-2xl font-bold border-b border-slate-700">
        HRIS-WAWAY
    </div>

    <!-- PROFILE -->
    <a href="{{ route('admin.profile_admin') }}"
        class="p-5 border-b border-slate-700 flex items-center gap-3 hover:bg-slate-800 transition cursor-pointer">

        <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
            <i data-lucide="user"></i>
        </div>

        <div>
            <div class="font-semibold text-sm">
                {{ Auth::user()->name }}
            </div>
            <div class="text-xs text-slate-400">
                {{ Auth::user()->role }}
            </div>
        </div>
    </a>

    <!-- MENU -->
    <nav class="mt-5 space-y-2 px-3">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 transition">
            <i data-lucide="layout-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <div class="relative">
            <button onclick="toggleDropdown()"
                class="flex items-center justify-between w-full gap-3 p-3 rounded-lg hover:bg-slate-800 transition">

                <div class="flex items-center gap-3">
                    <i data-lucide="file-plus"></i>
                    <span>Master Data</span>
                </div>

                <i data-lucide="chevron-down"></i>
            </button>

            <div id="dropdownSurat" class="hidden flex-col ml-8 mt-1 bg-slate-700 rounded-lg overflow-hidden">

                <a href="{{ route('admin.daftar.bagian') }}" class="block px-4 py-2 hover:bg-slate-600 transition">
                    Bagian
                </a>

                <a href="{{ route('admin.daftar.jabatan') }}"
                    class="block px-4 py-2 hover:bg-slate-600 transition">
                    Jabatan
                </a>
            </div>
        </div>

        <a href="{{ route('admin.daftarpegawai_admin') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 transition">
            <i data-lucide="inbox"></i>
            <span>Daftar Pegawai</span>
        </a>

        <a href="{{ route('admin.daftargaji_admin') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 transition">
            <i data-lucide="send"></i>
            <span>Daftar Gaji</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="absolute bottom-0 w-full p-4 border-t border-slate-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full flex items-center gap-2 text-left p-3 rounded-lg hover:bg-red-600 hover:text-white transition">
                <i data-lucide="log-out"></i>
                Logout
            </button>
        </form>
    </div>

</aside>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownSurat');
        dropdown.classList.toggle('hidden');
    }
</script>