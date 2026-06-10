<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Print Form Cuti
    </title>

    <script>
        window.onload = function () {

            window.print();

        }
    </script>

    <style>
        @page {
            size: F4 portrait;
            margin: 10mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            color: #000;
            line-height: 1.25;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px;
            vertical-align: top;
        }

        .border {
            border: 1px solid #000;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .label {
            width: 170px;
        }

        .mt {
            margin-top: 10px;
        }

        .box {
            border: 1px solid #000;
            padding: 8px;
            min-height: 45px;
        }

        .check {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 1px solid #000;
            text-align: center;
            line-height: 13px;
            margin-right: 4px;
            font-size: 10px;
        }

        .small {
            font-size: 10px;
        }

        .qr-wrapper {

            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 8px;

        }

        .qr {

            width: 55px;
            height: 55px;
            object-fit: contain;
            display: block;

        }

        .nama {

            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;

        }
    </style>

</head>

<body>

    {{-- TITLE --}}
    <div class="title">

        SURAT PERMOHONAN CUTI KARYAWAN

    </div>

    {{-- DATA PEGAWAI --}}
    <table>

        <tr>

            <td class="label">
                Nama
            </td>

            <td width="10">
                :
            </td>

            <td>

                {{ $cuti->pegawai->nama ?? '-' }}

            </td>

            <td class="label">
                Department
            </td>

            <td width="10">
                :
            </td>

            <td>

                {{ $cuti->pegawai->bagianRelasi->nama_bagian ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Jabatan
            </td>

            <td>
                :
            </td>

            <td>

                {{ $cuti->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}

            </td>

            <td class="label">
                Tanggal Diajukan
            </td>

            <td>
                :
            </td>

            <td>
                {{ $cuti->created_at->translatedFormat('l, d-m-Y') }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Cuti Mulai
            </td>

            <td>
                :
            </td>

            <td>

                {{ \Carbon\Carbon::parse($cuti->mulai_cuti)->translatedFormat('l, d-m-Y') }}

            </td>

            <td class="label">
                Sampai
            </td>

            <td>
                :
            </td>

            <td>

                {{ \Carbon\Carbon::parse($cuti->akhir_cuti)->translatedFormat('l, d-m-Y') }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Masuk Kembali
            </td>

            <td>
                :
            </td>

            <td>

                {{ $cuti->tgl_masuk }}

            </td>

            <td class="label">
                Total Hari
            </td>

            <td>
                :
            </td>

            <td>

                {{ $cuti->total_hari }} Hari

            </td>

        </tr>

        <tr>

            <td class="label">
                No Telp :
            </td>

            <td>
                :
            </td>

            <td>
                {{ $cuti->pegawai->no_hp ?? '-' }}

            </td>

            <td class="label">
                No Telp yang bisa dihubungi :
            </td>

            <td>
                :
            </td>

            <td>

                {{ $cuti->nomor_hp }}

            </td>

        </tr>

    </table>

    {{-- JENIS CUTI --}}
    <div class="mt">

        <span class="check">
            @if($cuti->jenis_cuti == 'Cuti Tahunan') ✓ @endif
        </span>
        Cuti Tahunan

        &nbsp;&nbsp;

        <span class="check">
            @if($cuti->jenis_cuti == 'Cuti Sakit') ✓ @endif
        </span>
        Cuti Sakit

        &nbsp;&nbsp;

        <span class="check">
            @if($cuti->jenis_cuti == 'Cuti Khusus') ✓ @endif
        </span>
        Cuti Khusus

    </div>

    {{-- KETERANGAN --}}
    <div class="mt">

        <div class="bold">
            Keterangan Cuti
        </div>

        <div class="box">

            {{ $cuti->keterangan }}

        </div>

    </div>

    {{-- ALAMAT --}}
    <div class="mt">

        <div class="bold">
            Alamat Selama Cuti
        </div>

        <div class="box">

            {{ $cuti->alamat }}

        </div>

    </div>

    {{-- USER CBS --}}
    <div class="mt">

        Mohon menonaktifkan USER CBS :

        <b>

            {{ $cuti->user_cbs }}

        </b>

        selama cuti.

    </div>

    {{-- BACKUP --}}
    @php
    $backup = $cuti->approval->where(
    'role_approval',
    'backup'
    )->first();
    @endphp

    <table class="border mt" width="100%">

        <tr>

            <th class="border center" width="50%">
                PEMOHON
            </th>

            <th class="border center" width="50%">
                KESEDIAAN PETUGAS BACKUP
            </th>

        </tr>

        <tr>

            <!-- PEMOHON -->
            <td class="border center" valign="top">

                Dengan form ini saya ingin mengajukan cuti.

                <br><br>

                Nama Pemohon :

                <b>
                    {{ $cuti->pegawai->nama ?? '-' }}
                </b>

                <div class="qr-wrapper">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($cuti->pegawai->nama ?? '', 'QRCODE') !!}"
                        class="qr">

                </div>

                <div class="nama">

                    {{ $cuti->pegawai->nama ?? '-' }}

                </div>

            </td>

            <!-- BACKUP -->
            <td class="border center" valign="top">

                Saya bersedia menjadi petugas backup selama pegawai menjalankan cuti.

                <br><br>

                Nama Backup :

                <b>

                    {{ $backup->pegawai->nama ?? '-' }}

                </b>

                <div class="qr-wrapper">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($backup->pegawai->nama ?? '', 'QRCODE') !!}"
                        class="qr">

                </div>

                <div class="nama">

                    {{ $backup->pegawai->nama ?? '-' }}

                </div>

            </td>

        </tr>

    </table>

    {{-- APPROVAL --}}

    <table class="border mt">

    
        <tr>

            <th colspan="4" class="border center" style="font-size:18px;">

                PT BPR WAWAY LAMPUNG (Perseroda)

            </th>

        </tr>


        <tr>

            <th class="border center">
                ATASAN LANGSUNG
            </th>

            <th class="border center">
                SDM
            </th>

            <th class="border center">
                DIREKTUR OPERASIONAL
            </th>

            <th class="border center">
                DIREKTUR UTAMA
            </th>

        </tr>

        <tr>

            {{-- KABAG --}}
            @php
            $kabag = $cuti->approval->where(
            'role_approval',
            'kepala_bagian'
            )->first();
            @endphp

            <td class="border small">

                Efektif :
                {{ $kabag->jumlah_hari ?? '-' }} Hari

                <br>

                {{ $kabag->cuti_efektif ?? '-' }}
                s/d
                {{ $kabag->sampai_dengan ?? '-' }}

                <br>

                Pengganti :
                {{ $kabag->petugas_pengganti ?? '-' }}

            </td>

            {{-- SDM --}}
            @php
            $sdm = $cuti->approval->where(
            'role_approval',
            'sdm'
            )->first();
            @endphp

            <td class="border small">

                Hak :
                {{ $sdm->hak_hari_cuti ?? '-' }} Hari

                <br>

                Dijalani :
                {{ $sdm->telah_dijalani ?? '-' }} Hari

                <br>

                Potong :
                {{ $sdm->izin_potong_cuti ?? '-' }} Hari

                <br>

                Sisa :
                {{ $sdm->sisa_hari_cuti ?? '-' }} Hari

                <br>

                Setelah :
                {{ $sdm->sisa_setelah_cuti ?? '-' }} Hari

            </td>

            {{-- DIROP --}}
            @php
            $dirop = $cuti->approval->where(
            'role_approval',
            'direktur_operasional'
            )->first();
            @endphp

            <td class="border small">

                Pengganti :
                {{ $dirop->petugas_pengganti ?? '-' }}

                <br>

                Catatan :

                <br>

                {{ $dirop->catatan ?? '-' }}

            </td>

            {{-- DIRUT --}}
            @php
            $dirut = $cuti->approval->where(
            'role_approval',
            'direktur_utama'
            )->first();
            @endphp

            <td class="border small">

                Efektif :
                {{ $dirut->jumlah_hari ?? '-' }} Hari

                <br>

                {{ $dirut->cuti_efektif ?? '-' }}
                s/d
                {{ $dirut->sampai_dengan ?? '-' }}

                <br>

                Pengganti :
                {{ $dirut->petugas_pengganti ?? '-' }}

                <br>

                Catatan :

                <br>

                {{ $dirut->catatan ?? '-' }}

            </td>

        </tr>

        {{-- QR --}}
        <tr>

            {{-- ATASAN LANGSUNG --}}
            <td class="border center small">

                <div class="ttd-title">
                    {{ $kabag->status == 'disetujui'
                ? 'Dikabulkan'
                : ucfirst($kabag->status ?? '-') }}
                </div>

                <div class="jabatan-title">
                    ATASAN LANGSUNG
                </div>

                <div class="qr-wrapper">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($kabag->pegawai->nama ?? '', 'QRCODE') !!}"
                        class="qr">

                </div>

                <div class="nama">

                    {{ $kabag->pegawai->nama ?? '-' }}

                </div>

            </td>

            {{-- SDM --}}
            <td class="border center small">

                <div class="ttd-title">
                    {{ $sdm->status == 'disetujui'
                ? 'Diperiksa'
                : ucfirst($sdm->status ?? '-') }}
                </div>

                <div class="jabatan-title">
                    SDM
                </div>

                <div class="qr-wrapper">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($sdm->pegawai->nama ?? '', 'QRCODE') !!}"
                        class="qr">

                </div>

                <div class="nama">

                    {{ $sdm->pegawai->nama ?? '-' }}

                </div>

            </td>

            {{-- DIREKTUR OPERASIONAL --}}
            <td class="border center small">

                <div class="ttd-title">
                    {{ $dirop->status == 'disetujui'
                ? 'Disetujui'
                : ucfirst($dirop->status ?? '-') }}
                </div>

                <div class="jabatan-title">
                    DIREKTUR OPERASIONAL
                </div>

                <div class="qr-wrapper">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($dirop->pegawai->nama ?? '', 'QRCODE') !!}"
                        class="qr">

                </div>

                <div class="nama">

                    {{ $dirop->pegawai->nama ?? '-' }}

                </div>

            </td>

            {{-- DIREKTUR UTAMA --}}
            <td class="border center small">

                <div class="ttd-title">
                    {{ $dirut->status == 'disetujui'
                ? 'Disetujui'
                : ucfirst($dirut->status ?? '-') }}

                    <div class="jabatan-title">
                        DIREKTUR UTAMA
                    </div>

                    <div class="qr-wrapper">

                        <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($dirut->pegawai->nama ?? '', 'QRCODE') !!}"
                            class="qr">

                    </div>

                    <div class="nama">

                        {{ $dirut->pegawai->nama ?? '-' }}

                    </div>

            </td>

        </tr>

    </table>

    <style>
        .ttd-title {

            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;

        }

        .jabatan-title {

            font-size: 10px;
            margin-top: 2px;
            margin-bottom: 4px;

        }

        .qr-wrapper {

            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 6px;

        }

        .qr {

            width: 55px;
            height: 55px;
            object-fit: contain;

        }

        .nama {

            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;

        }

        .small {

            font-size: 10px;

        }

        .border {

            border: 1px solid #000;

        }

        .center {

            text-align: center;

        }
    </style>

</body>

</html>