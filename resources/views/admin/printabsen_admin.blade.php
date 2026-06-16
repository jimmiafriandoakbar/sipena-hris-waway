<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Bulanan</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            color: #000;
        }

        h2,
        h4 {
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

        th,
        td {
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
            color: #64748b;
            white-space: nowrap;
        }

        .masuk {
            display: block;
        }

        .pulang {
            display: block;
            margin-top: 1px;
        }

        .total {
            width: 40px;
            min-width: 40px;
            font-size: 8px;
            font-weight: bold;
        }

        .no {
            width: 25px;
        }

        .btn-print {
            margin-bottom: 10px;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="btn-print">
        <button onclick="window.print()">
            Print
        </button>
    </div>

    <h2>REKAP ABSENSI PEGAWAI</h2>

    <h4>
        Bulan
        {{ \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }}
        Tahun {{ $tahun }}
    </h4>

    <table>

        <thead>
            <tr>

                <th class="no">No</th>

                <th class="nama">
                    Nama Pegawai
                </th>

                @for($i = 1; $i <= $jumlahHari; $i++)
                    <th class="tanggal">
                        {{ $i }}
                    </th>
                @endfor

                <th class="total">
                    Hadir
                </th>

            </tr>
        </thead>

        <tbody>

            @foreach($pegawais as $pegawai)

                @php
                    $totalHadir = 0;
                @endphp

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="nama">
                        {{ $pegawai->nama }}
                    </td>

                    @for($i = 1; $i <= $jumlahHari; $i++)

                        @php

                            $tanggal = \Carbon\Carbon::create(
                                $tahun,
                                $bulan,
                                $i
                            )->toDateString();

                            $absen = $pegawai->absensis
                                ->firstWhere('tanggal', $tanggal);

                            if ($absen && $absen->jam_masuk) {
                                $totalHadir++;
                            }

                        @endphp

                        <td class="jam">

                            @if($absen && $absen->jam_masuk)

                                <span class="masuk">
                                    {{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}
                                </span>

                                <span class="pulang">

                                    @if($absen->jam_pulang)

                                        {{ \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') }}

                                    @else

                                        -

                                    @endif

                                </span>

                            @else

                                -

                            @endif

                        </td>

                    @endfor

                    <td class="total">
                        {{ $totalHadir }}
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