<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Daftar Gaji</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop h2, .kop h3 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #e5e7eb;
            font-weight: bold;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f3f4f6;
        }

        .ttd {
            width: 300px;
            margin-left: auto;
            text-align: center;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()">Print</button>
    </div>

    <div class="kop">
        <h2>PT BPR WAWAY LAMPUNG (PERSERODA)</h2>
        <h3>DAFTAR GAJI PEGAWAI</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>

                <th>Gaji Pokok</th>
                <th>Tunj. Teller</th>
                <th>Tunj. Anak</th>
                <th>Tunj. Istri</th>
                <th>Tunj. Kemahalan</th>
                <th>Tunj. Jabatan</th>
                <th>Total GaTu</th>

                <th>Koperasi</th>
                <th>Koperasi Pinj</th>
                <th>Infaq</th>
                <th>BPJS Sehat</th>
                <th>BPJS Kerja</th>
                <th>Tab Pensiun</th>
                <th>Pinj Pegawai</th>
                <th>Pot Lain</th>
                <th>Total Pot</th>

                <th>Total Bersih</th>
            </tr>
        </thead>

        <tbody>
            @php
                $grandGaji = 0;
                $grandPotongan = 0;
                $grandBersih = 0;
            @endphp

            @foreach ($payrolls as $item)
                @php
                    $totalGajiTunjangan =
                        $item->gaji_pokok +
                        $item->tunjangan_teller +
                        $item->tunjangan_anak +
                        $item->tunjangan_istri +
                        $item->tunjangan_kemahalan +
                        $item->tunjangan_lain_lain;

                    $totalPotongan =
                        $item->koperasi +
                        $item->koperasi_pinjaman +
                        $item->infaq +
                        $item->bpjs_kesehatan +
                        $item->bpjs_ketenagakerjaan +
                        $item->tabungan_pensiun +
                        $item->pinjaman_pegawai +
                        $item->potongan_lain_lain;

                    $totalBersih = $totalGajiTunjangan - $totalPotongan;

                    $grandGaji += $totalGajiTunjangan;
                    $grandPotongan += $totalPotongan;
                    $grandBersih += $totalBersih;
                @endphp

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->pegawai->nama ?? '-' }}</td>
                    <td>{{ $item->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}</td>

                    <td class="text-right">{{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tunjangan_teller, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tunjangan_anak, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tunjangan_istri, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tunjangan_kemahalan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tunjangan_lain_lain, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>{{ number_format($totalGajiTunjangan, 0, ',', '.') }}</strong></td>

                    <td class="text-right">{{ number_format($item->koperasi, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->koperasi_pinjaman, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->infaq, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->bpjs_kesehatan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->bpjs_ketenagakerjaan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->tabungan_pensiun, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->pinjaman_pegawai, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->potongan_lain_lain, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>{{ number_format($totalPotongan, 0, ',', '.') }}</strong></td>

                    <td class="text-right">
                        <strong>{{ number_format($totalBersih, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="9" class="text-center">TOTAL KESELURUHAN</td>
                <td class="text-right">{{ number_format($grandGaji, 0, ',', '.') }}</td>

                <td colspan="8"></td>
                <td class="text-right">{{ number_format($grandPotongan, 0, ',', '.') }}</td>

                <td class="text-right">{{ number_format($grandBersih, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="ttd">
    Bandar Lampung,
    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

    <br>
    PT BPR WAWAY LAMPUNG (Perseroda)

    <br><br>
    Menyetujui,

    <br><br><br><br><br>

    <strong>(HARRIS SURAHYA)</strong>

    <br>
    Direktur Utama
</div>

</body>
</html>