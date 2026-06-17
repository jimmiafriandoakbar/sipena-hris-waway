@extends('layouts.admin.app_admin')

@section('content')

@if(session('success'))
<div id="alertSuccess" class="fixed top-5 right-5 z-50 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div id="alertError" class="fixed top-5 right-5 z-50 bg-red-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
    <i data-lucide="x-circle" class="w-5 h-5"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<div class="mb-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Daftar Pegawai</h1>
        <p class="text-sm text-slate-500 mt-1">Data pegawai dalam sistem SIPENA</p>
    </div>

    <a href="{{ route('admin.pegawai.create') }}"
       class="h-11 px-5 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition inline-flex items-center justify-center shadow-sm">
        + Add Pegawai
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="p-5 border-b bg-slate-50/70">
        <form method="GET" action="{{ route('admin.daftarpegawai_admin') }}"
              class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

            <div class="w-full xl:w-80">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama / NIP / email..."
                       class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="flex flex-wrap items-center gap-3">

                <select name="bagian"
                        class="h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">
                    <option value="">Semua Bagian</option>

                    @foreach($bagians as $bagian)
                        <option value="{{ $bagian->nama_bagian }}"
                            {{ request('bagian') == $bagian->nama_bagian ? 'selected' : '' }}>
                            {{ $bagian->nama_bagian }}
                        </option>
                    @endforeach
                </select>

                <select name="jabatan"
                        class="h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">
                    <option value="">Semua Jabatan</option>

                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->nama_jabatan }}"
                            {{ request('jabatan') == $jabatan->nama_jabatan ? 'selected' : '' }}>
                            {{ $jabatan->nama_jabatan }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="h-11 px-5 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                    Cari
                </button>

                <a href="{{ route('admin.daftarpegawai_admin') }}"
                   class="h-11 px-5 rounded-xl border border-slate-300 text-sm hover:bg-white transition flex items-center">
                    Reset
                </a>
            </div>

            <div class="text-sm text-slate-500 whitespace-nowrap">
                Total
                <span class="font-semibold text-slate-700">
                    {{ $pegawai->total() }}
                </span>
                data
            </div>

        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Bagian</th>
                    <th class="px-6 py-4 text-left">Jabatan</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">No HP</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pegawai as $index => $p)
                <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition">

                    <td class="px-6 py-4">
                        {{ $pegawai->firstItem() + $index }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-800">
                            {{ $p->nama }}
                        </div>

                        <div class="text-xs text-slate-400 mt-1">
                            {{ $p->nip }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $p->bagianRelasi->nama_bagian ?? '-' }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        {{ $p->jabatanRelasi->nama_jabatan ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $p->email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $p->no_hp }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-end items-center gap-2">

                            <button
                                type="button"
                                onclick='openDetailModal({
                                    nama: @json($p->nama),
                                    nip: @json($p->nip),
                                    bagian: @json($p->bagianRelasi->nama_bagian ?? "-"),
                                    jabatan: @json($p->jabatanRelasi->nama_jabatan ?? "-"),
                                    pendidikan: @json($p->pendidikan),
                                    jurusan: @json($p->jurusan),
                                    mulai_bekerja: @json($p->mulai_bekerja),
                                    nomor_rekening: @json($p->nomor_rekening),
                                    email: @json($p->email),
                                    no_hp: @json($p->no_hp),
                                    gaji_pokok: @json($p->gaji_pokok),
                                    tunjangan: @json($p->tunjangan),
                                    bonus: @json($p->bonus),
                                    potongan: @json($p->potongan),
                                    created_at: @json(optional($p->created_at)->format("d-m-Y H:i"))
                                })'
                                class="h-9 px-4 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition text-xs font-medium">
                                Detail
                            </button>

                            <a href="{{ route('admin.pegawai.edit', $p->id) }}"
                               class="h-9 px-4 rounded-lg border border-blue-500 text-blue-600 hover:bg-blue-50 transition text-xs font-medium inline-flex items-center">
                                Edit
                            </a>

                            <form action="{{ route('admin.pegawai.delete', $p->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus pegawai ini?')"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="h-9 px-4 rounded-lg border border-red-500 text-red-600 hover:bg-red-50 transition text-xs font-medium">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-10 text-center text-slate-500">
                        Data pegawai tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between px-5 py-4 border-t bg-slate-50">
        <div class="text-sm text-slate-500">
            Menampilkan
            {{ $pegawai->firstItem() ?? 0 }}
            -
            {{ $pegawai->lastItem() ?? 0 }}
            dari
            {{ $pegawai->total() }}
            data
        </div>

        <div class="flex items-center gap-2">
            {{ $pegawai->links() }}
        </div>
    </div>

</div>

<div id="detailModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">

    <div class="relative w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">

        <div class="sticky top-0 z-10 bg-white border-b px-8 py-5 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Detail Pegawai</h2>
                <p class="text-sm text-slate-500 mt-1">Informasi lengkap pegawai SIPENA</p>
            </div>

            <button type="button"
                    onclick="closeDetailModal()"
                    class="w-10 h-10 rounded-xl hover:bg-red-50 text-slate-400 hover:text-red-500 transition flex items-center justify-center text-xl">
                ✕
            </button>
        </div>

        <div class="overflow-y-auto max-h-[75vh] px-8 py-7 space-y-8">

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1.5 h-6 rounded-full bg-blue-500"></div>
                    <h3 class="text-sm font-semibold tracking-wide uppercase text-slate-700">Data Pegawai</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    <div class="detail-card"><label>Nama Lengkap</label><h4 id="detailNama"></h4></div>
                    <div class="detail-card"><label>NIP</label><h4 id="detailNip"></h4></div>
                    <div class="detail-card"><label>Bagian</label><h4 id="detailBagian"></h4></div>
                    <div class="detail-card"><label>Jabatan</label><h4 id="detailJabatan"></h4></div>
                    <div class="detail-card"><label>Pendidikan</label><h4 id="detailPendidikan"></h4></div>
                    <div class="detail-card"><label>Jurusan</label><h4 id="detailJurusan"></h4></div>
                    <div class="detail-card"><label>Mulai Bekerja</label><h4 id="detailMulai"></h4></div>
                    <div class="detail-card"><label>Nomor Rekening</label><h4 id="detailRekening"></h4></div>
                    <div class="detail-card"><label>Tanggal Dibuat</label><h4 id="detailCreated"></h4></div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1.5 h-6 rounded-full bg-emerald-500"></div>
                    <h3 class="text-sm font-semibold tracking-wide uppercase text-slate-700">Informasi Kontak</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="detail-card"><label>Email</label><h4 id="detailEmail" class="break-all"></h4></div>
                    <div class="detail-card"><label>No HP</label><h4 id="detailHp"></h4></div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1.5 h-6 rounded-full bg-yellow-500"></div>
                    <h3 class="text-sm font-semibold tracking-wide uppercase text-slate-700">Data Gaji</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                    <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5">
                        <p class="text-xs text-emerald-600 mb-2 uppercase tracking-wide">Gaji Pokok</p>
                        <h3 class="text-2xl font-bold text-emerald-700">Rp <span id="detailGaji"></span></h3>
                    </div>

                    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">
                        <p class="text-xs text-blue-600 mb-2 uppercase tracking-wide">Tunjangan</p>
                        <h3 class="text-2xl font-bold text-blue-700">Rp <span id="detailTunjangan"></span></h3>
                    </div>

                    <div class="rounded-2xl bg-yellow-50 border border-yellow-100 p-5">
                        <p class="text-xs text-yellow-600 mb-2 uppercase tracking-wide">Bonus</p>
                        <h3 class="text-2xl font-bold text-yellow-700">Rp <span id="detailBonus"></span></h3>
                    </div>

                    <div class="rounded-2xl bg-red-50 border border-red-100 p-5">
                        <p class="text-xs text-red-600 mb-2 uppercase tracking-wide">Potongan</p>
                        <h3 class="text-2xl font-bold text-red-700">Rp <span id="detailPotongan"></span></h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="sticky bottom-0 bg-white border-t px-8 py-5 flex justify-end">
            <button type="button"
                    onclick="closeDetailModal()"
                    class="h-11 px-6 rounded-xl border border-slate-300 text-sm font-medium hover:bg-slate-50 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
.detail-card{
    background:#f8fafc;
    border-radius:1rem;
    padding:1.25rem;
    border:1px solid #f1f5f9;
}

.detail-card label{
    font-size:.75rem;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#64748b;
    display:block;
    margin-bottom:.5rem;
}

.detail-card h4{
    font-size:1rem;
    font-weight:600;
    color:#1e293b;
}
</style>

<script>
function openDetailModal(p) {
    document.getElementById('detailNama').innerText = p.nama ?? '-';
    document.getElementById('detailNip').innerText = p.nip ?? '-';
    document.getElementById('detailBagian').innerText = p.bagian ?? '-';
    document.getElementById('detailJabatan').innerText = p.jabatan ?? '-';
    document.getElementById('detailPendidikan').innerText = p.pendidikan ?? '-';
    document.getElementById('detailJurusan').innerText = p.jurusan ?? '-';
    document.getElementById('detailMulai').innerText = p.mulai_bekerja ?? '-';
    document.getElementById('detailRekening').innerText = p.nomor_rekening ?? '-';
    document.getElementById('detailEmail').innerText = p.email ?? '-';
    document.getElementById('detailHp').innerText = p.no_hp ?? '-';

    document.getElementById('detailGaji').innerText =
        new Intl.NumberFormat('id-ID').format(p.gaji_pokok ?? 0);

    document.getElementById('detailTunjangan').innerText =
        new Intl.NumberFormat('id-ID').format(p.tunjangan ?? 0);

    document.getElementById('detailBonus').innerText =
        new Intl.NumberFormat('id-ID').format(p.bonus ?? 0);

    document.getElementById('detailPotongan').innerText =
        new Intl.NumberFormat('id-ID').format(p.potongan ?? 0);

    document.getElementById('detailCreated').innerText = p.created_at ?? '-';

    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailModal').classList.add('flex');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('detailModal').classList.remove('flex');
}

setTimeout(() => {
    const success = document.getElementById('alertSuccess');

    if (success) {
        success.style.transition = '.4s';
        success.style.opacity = '0';

        setTimeout(() => {
            success.remove();
        }, 400);
    }
}, 3000);

setTimeout(() => {
    const error = document.getElementById('alertError');

    if (error) {
        error.style.transition = '.4s';
        error.style.opacity = '0';

        setTimeout(() => {
            error.remove();
        }, 400);
    }
}, 3000);
</script>

@endsection