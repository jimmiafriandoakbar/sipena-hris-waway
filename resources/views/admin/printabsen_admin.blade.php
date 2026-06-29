<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Rekap Absensi</title>

    <style>
        @page { size: A4 landscape; margin: 5mm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            color: #000;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        h4 {
            margin-bottom: 10px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 1px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background: #e2e8f0;
            font-size: 7px;
            font-weight: bold;
        }

        .no { width: 25px; }

        .nama {
            text-align: left;
            width: 140px;
            min-width: 140px;
            padding-left: 5px;
            font-size: 8px;
            font-weight: 600;
        }

        .tanggal {
            width: 18px;
            min-width: 18px;
            font-size: 6px;
        }

        .jam {
            width: 18px;
            min-width: 18px;
            font-size: 6px;
            line-height: 1.1;
            white-space: nowrap;
        }

        .masuk, .pulang {
            display: block;
        }

        .pulang {
            margin-top: 1px;
        }

        .total {
            width: 40px;
            min-width: 40px;
            font-size: 8px;
            font-weight: bold;
        }

        .btn-print {
            margin-bottom: 10px;
        }

        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>

<body>

<div class="btn-print">
    <button onclick="window.print()">Print</button>
</div>

<h2>REKAP ABSENSI PEGAWAI</h2>
<h4>
    Periode
    {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}
    s/d
    {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
</h4>

<table>
    <thead>
        <tr>
            <th class="no">No</th>
            <th class="nama">Nama Pegawai</th>

            @foreach($daftarTanggal as $tgl)
                <th class="tanggal">
                    {{ $tgl->format('d') }}<br>
                    {{ $tgl->translatedFormat('D') }}
                </th>
            @endforeach

            <th class="total">Hadir</th>
            <th class="total">Telat</th>
            <th class="total">PC</th>
            <th class="total">Lembur</th>
        </tr>
    </thead>

    <tbody>
        @foreach($pegawais as $pegawai)
            @php
                $totalHadir = 0;
                $totalTelat = 0;
                $totalPulangCepat = 0;
                $totalMenitLembur = 0;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td class="nama">{{ $pegawai->nama }}</td>

                @foreach($daftarTanggal as $tgl)
                    @php
                        $tanggal = $tgl->toDateString();
                        $absen = $pegawai->absensis->firstWhere('tanggal', $tanggal);

                        if ($absen && $absen->jam_masuk) {
                            $totalHadir++;
                        }

                        if ($absen && $absen->status_masuk == 'terlambat') {
                            $totalTelat++;
                        }

                        if ($absen && $absen->status_pulang == 'pulang_cepat') {
                            $totalPulangCepat++;
                        }

                        if ($absen) {
                            $totalMenitLembur += $absen->total_menit_lembur ?? 0;
                        }
                    @endphp

                    <td class="jam">
                        @if($absen && $absen->jam_masuk)
                            <span class="masuk">
                                {{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}
                            </span>

                            <span class="pulang">
                                {{ $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '-' }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                @endforeach

                <td class="total">{{ $totalHadir }}</td>
                <td class="total">{{ $totalTelat }}</td>
                <td class="total">{{ $totalPulangCepat }}</td>
                <td class="total">
                    {{ floor($totalMenitLembur / 60) }}j {{ $totalMenitLembur % 60 }}m
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.onload = function() {
        window.print();
    }
</script>

</body>
</html>