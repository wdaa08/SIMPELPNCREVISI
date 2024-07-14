<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelaporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat img {
            height: auto;
            vertical-align: middle;
        }

        .kop-surat h1,
        .kop-surat h2,
        .kop-surat p {
            margin: 0;
            padding: 0;
        }

        .kop-surat .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .line {
            border: 1px solid black;
            margin: 10px 0;
        }

        .content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .signature img {
            width: 150px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <div class="header">
            {{-- <img src="{{ public_path('img/logopnc.png') }}" alt="Logo Kiri" style="width: 80px;"> --}}
            <div>
                <h2>KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h2>
                <h2>POLITEKNIK NEGERI CILACAP</h2>
                <p>PENCEGAHAN DAN PENANGANAN KEKERASAN SEKSUAL</p>
                <p>Jalan Dr. Soetomo No. 1, Sidakaya - CILACAP 53212 Jawa Tengah</p>
                <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
                <p>www.pnc.ac.id, Email: sekretariat@pnc.ac.id</p>
            </div>
            {{-- <img src="{{ public_path('img/logoppks.png') }}" alt="Logo Kanan" style="width: 80px;"> --}}
        </div>
        <div class="line"></div>
        <h3>DATA LAPORAN WEBSITE SIMPEL-PNC</h3>
    </div>

    <div class="content">
        <h2>Detail Pelaporan</h2>

        <!-- Tabel Jumlah Pengguna dan Laporan -->
        <h3>Jumlah Pengguna dan Laporan</h3>
        <table>
            <thead>
                <tr>
                    <th>Jumlah Pengguna</th>
                    <th>Jumlah Laporan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $jumlahUser }}</td>
                    <td>{{ $jumlahLaporan }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Tabel Laporan per Jurusan -->
        <h3>Laporan Per Jurusan</h3>
        <table>
            <thead>
                <tr>
                    <th>Jurusan</th>
                    <th>Total Laporan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPerJurusan as $laporan)
                <tr>
                    <td>{{ $laporan->jurusan }}</td>
                    <td>{{ $laporan->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel Laporan per Program Studi -->
        <h3>Laporan Per Program Studi</h3>
        <table>
            <thead>
                <tr>
                    <th>Program Studi</th>
                    <th>Total Laporan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPerProdi as $laporan)
                <tr>
                    <td>{{ $laporan->prodi }}</td>
                    <td>{{ $laporan->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel Laporan per Bulan -->
        <h3>Laporan Per Bulan</h3>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Total Laporan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPerBulan as $laporan)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }}</td>
                    <td>{{ $laporan->tahun }}</td>
                    <td>{{ $laporan->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel Status Terlapor -->
        <h3>Status Terlapor</h3>
        <table>
            <thead>
                <tr>
                    <th>Status Terlapor</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statusTerlapor as $status)
                <tr>
                    <td>{{ $status->status_terlapor }}</td>
                    <td>{{ $status->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel Jenis Kekerasan Seksual -->
        <h3>Jenis Kekerasan Seksual</h3>
        <table>
            <thead>
                <tr>
                    <th>Jenis Kekerasan Seksual</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisKekerasanSeksual as $jks)
                <tr>
                    <td>{{ $jks->jenis_kekerasan_seksual }}</td>
                    <td>{{ $jks->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
