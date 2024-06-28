<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kop-surat img {
            width: 80px; /* Ukuran logo */
            height: auto;
        }

        .kop-surat .text-center {
            flex: 1;
            padding: 0 10px;
        }

        .kop-surat h1,
        .kop-surat h2,
        .kop-surat p {
            margin: 0;
            padding: 0;
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
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .signature {
            margin-top: 30px;
            text-align: center;
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
       
            <div class="text-center">
                <h1>  <img src="{{ public_path('img/logopnc.png') }}" alt="Logo Kanan"> KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI  <img src="{{ public_path('img/logoppks.png') }}" alt="Logo Kiri"> </h1>
                <h2>POLITEKNIK NEGERI CILACAP</h2>
                <p>PENCEGAHAN DAN PENANGANAN KEKERASAN SEKSUAL</p>
                <p>Jalan Dr. Soetomo No. 1, Sidakaya - CILACAP 53212 Jawa Tengah</p>
                <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
                <p><a href="http://www.pnc.ac.id">www.pnc.ac.id</a>, Email: <a href="mailto:sekretariat@pnc.ac.id">sekretariat@pnc.ac.id</a></p>
            </div>
               
            
        </div>
        <div class="line"></div>
        <p><strong>FORM PELAPORAN KASUS KEKERASAN SEKSUAL</strong></p>
        <p><strong>SATUAN TUGAS PPKS POLITEKNIK NEGERI CILACAP</strong></p>
    </div>

    <div class="content">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-6">
                <h2>Laporan Per Jurusan</h2>
                <ul>
                    @foreach ($laporanPerJurusan as $laporan)
                        <li>{{ $laporan->jurusan }}: {{ $laporan->total }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6 col-xl-6">
                <h2>Laporan Per Program Studi</h2>
                <ul>
                    @foreach ($laporanPerProdi as $laporan)
                        <li>{{ $laporan->prodi }}: {{ $laporan->total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- Tambahkan bagian lain sesuai kebutuhan -->
    </div>

    <div class="signature">
        <p>__________________________</p>
        <p>Tanda Tangan</p>
    </div>
</body>

</html>
