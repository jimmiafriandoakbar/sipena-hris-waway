<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Surat</title>

    <script>
        window.onload = function () {

            window.print();

        }
    </script>

    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 40px;
            color: #000;
            font-size: 16px;
            line-height: 1.7;
        }

        .kop {
            text-align: center;
            margin-bottom: 30px;
        }

        .nota-box {
            width: 320px;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .nota-box td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: center;
            font-weight: bold;
        }

        .info {
            width: 100%;
            margin-bottom: 25px;
        }

        .info td {
            padding: 3px 0;
            vertical-align: top;
        }

        .label {
            width: 150px;
        }

        .titik {
            width: 20px;
            text-align: center;
        }

        .isi {
            text-align: justify;
            margin-top: 20px;
            line-height: 1.5;
            font-size: 18px;
        }

        .footer {
            width: 100%;
            margin-top: 60px;
        }

        .ttd-box {
            width: 260px;
            text-align: center;
        }

        .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10px;
        }

        .jabatan {
            font-style: italic;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 20px 0;
        }

        .table-lembur {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 15px;
        }

        .table-lembur th {
            border: 1px solid #000;
            padding: 10px;
            background: #f3f3f3;
            text-align: center;
            font-weight: bold;
        }

        .table-lembur td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: middle;
        }

        .check-box {
            width: 22px;
            height: 22px;

            border: 2px solid black;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            font-size: 16px;
            font-weight: bold;

            margin-right: 10px;
        }

        .table-check {
            margin-top: 25px;
        }
    </style>
</head>

<body>

    {{-- ===================================================== --}}
    {{-- TEMPLATE KHUSUS FORM LEMBUR --}}
    {{-- ===================================================== --}}
    @if(strtolower($surat->jenis_surat) == 'form lembur')

    <table class="nota-box">

        <tr>

            <td colspan="3">

                FORM LEMBUR
                {{ strtoupper($surat->pegawai->bagianRelasi->kode_bagian ?? '') }}

            </td>

        </tr>

        <tr>

            <td style="width:70px;">
                NO
            </td>

            <td style="width:10px;">
                :
            </td>

            <td>
                {{ $surat->nomor_surat }}
            </td>

        </tr>

    </table>

    <table class="info">

        <tr>

            <td class="label">
                Nama
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur?->pengaju?->nama ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Jabatan
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur?->pengaju?->jabatanRelasi?->nama_jabatan ?? '-' }}
                -
                {{ $surat->lembur?->pengaju?->bagianRelasi?->nama_bagian ?? '-' }}

            </td>

        </tr>

    </table>

    <div class="isi">

        Mengajukan kebutuhan untuk
        <b><u>LEMBUR</u></b>
        dengan rincian sebagai berikut :

    </div>

    <table class="info" style="margin-top:20px;">

        <tr>

            <td class="label">
                Pekerjaan
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur->pekerjaan ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Area
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur->area ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Tanggal
            </td>

            <td class="titik">
                :
            </td>

            <td>
                {{ \Carbon\Carbon::parse($surat->lembur->tanggal_lembur)->translatedFormat('l,') }}
                {{ $surat->lembur->tanggal_lembur ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Jam
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur->jam_lembur ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Jumlah Tenaga
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->lembur->jumlah_tenaga ?? '-' }}

            </td>

        </tr>

    </table>

    {{-- TABEL PEGAWAI --}}
    <table class="table-lembur">

        <thead>

            <tr>

                <th style="width:60px; text-align:center;">
                    No
                </th>

                <th>
                    Nama Pegawai
                </th>

                <th>
                    Jabatan
                </th>

            </tr>

        </thead>

        <tbody>

            @php

            $pegawaiIds =
            json_decode(
            $surat->lembur->pegawai_lembur ?? '[]',
            true
            );

            $pegawaiLembur =
            \App\Models\Pegawai::with([
            'jabatanRelasi'
            ])
            ->whereIn(
            'id',
            $pegawaiIds
            )
            ->get();

            @endphp

            @forelse($pegawaiLembur as $index => $item)

            <tr>

                <td style="text-align:center;">

                    {{ $index + 1 }}

                </td>

                <td>

                    {{ $item->nama }}

                </td>

                <td>

                    {{ $item->jabatanRelasi->nama_jabatan ?? '-' }}-
                    {{ $item->bagianRelasi->nama_bagian ?? '-' }}
                </td>

            </tr>

            @empty

            <tr>

                <td colspan="3" style="text-align:center;">

                    Tidak ada data pegawai lembur

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <table class="table-check" style="font-family: serif; font-size: 16px; margin-top: 20px;">

        <tr>

            <td style="vertical-align: top; padding-right: 20px;">
                Disetujui / Ditolak
            </td>

            <td style="vertical-align: top; padding-right: 20px;">
                :
            </td>

            <td>

                <div style="margin-bottom: 12px;">

                    <span class="check-box">

                        @if($surat->status == 'disetujui')
                        ✓
                        @endif

                    </span>

                    Disetujui

                </div>

                <div>

                    <span class="check-box">

                        @if($surat->status == 'ditolak')
                        ✓
                        @endif

                    </span>

                    Ditolak

                </div>

            </td>

        </tr>

    </table>

    {{-- TTD --}}
    <table class="footer">

        <div align="center" class="table-check">

            Bandar Lampung,
            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

        </div>

        <tr>

            <td align="center">

                Diajukan Oleh

                <div style="margin-top:30px;">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($surat->lembur->pengaju->nama, 'QRCODE') !!}"
                        width="90">

                </div>

                <div class="nama-ttd">

                    {{ $surat->lembur->pengaju->nama }}

                </div>

                <div class="jabatan">

                    {{ $surat->lembur?->pengaju?->bagianRelasi?->nama_bagian ?? '-' }}

                </div>

            </td>

            <td align="center">

                Disetujui Oleh

                @php
                $lastTtd = $surat->ttd->last();
                @endphp

                <div style="margin-top:30px;">

                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($lastTtd->pegawai->nama ?? '', 'QRCODE') !!}"
                        width="90">

                </div>

                <div class="nama-ttd">

                    {{ $lastTtd->pegawai->nama ?? '-' }}

                </div>

                <div class="jabatan">

                    {{ $lastTtd->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}

                </div>

            </td>

        </tr>

    </table>

    {{-- ===================================================== --}}
    {{-- TEMPLATE SURAT NORMAL --}}
    {{-- ===================================================== --}}
    @else

    <!-- HEADER -->
    <table class="nota-box">

        <tr>

            <td colspan="3">

                {{ strtoupper($surat->jenis_surat ?? '') }}
                {{ strtoupper($surat->pegawai->bagianRelasi->kode_bagian ?? '') }}

            </td>

        </tr>

        <tr>

            <td style="width:70px;">
                NO
            </td>

            <td style="width:10px;">
                :
            </td>

            <td>

                {{ $surat->nomor_surat }}

            </td>

        </tr>

    </table>

    <!-- INFO -->
    <table class="info">

        <tr>

            <td class="label">
                Kepada
            </td>

            <td class="titik">
                :
            </td>

            <td>

                @foreach($surat->tujuan as $item)

                {{ $item->bagian->nama_bagian ?? '-' }}

                @if(!$loop->last)
                ,
                @endif

                @endforeach

            </td>

        </tr>

        <tr>

            <td class="label">
                Dari Bagian
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ strtoupper($surat->pegawai->bagianRelasi->nama_bagian ?? '') }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Tanggal
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Perihal
            </td>

            <td class="titik">
                :
            </td>

            <td>

                {{ $surat->perihal }}

            </td>

        </tr>

    </table>

    <hr>

    <!-- ISI -->
    <div class="isi">

        <p>
            {!! nl2br(e(trim($surat->isi_surat))) !!}
        </p>

    </div>

    <!-- FOOTER -->
    <table class="footer">

        <tr>

            <td style="width:50%;"></td>

            <td>

                <div class="ttd-box">

                    <div>

                        Bandar Lampung,
                        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

                    </div>

                    <div>
                        Hormat kami,
                    </div>

                    <div style="display:flex; gap:50px; justify-content:center;">

                        @foreach($surat->ttd as $ttd)

                        <div class="ttd-box">

                            <div style="
                                    display:flex;
                                    flex-direction:column;
                                    align-items:center;
                                    margin-bottom:10px;
                                ">

                                <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($ttd->pegawai->nama ?? '', 'QRCODE') !!}"
                                    style="
                                        width:90px;
                                        height:90px;
                                        object-fit:contain;
                                    ">

                            </div>

                            <div class="nama-ttd">

                                {{ $ttd->pegawai->nama ?? '-' }}

                            </div>

                            <div class="jabatan">

                                {{ $ttd->pegawai->bagianRelasi->nama_bagian ?? '-' }}

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            </td>

        </tr>

    </table>

    @endif

</body>

</html>