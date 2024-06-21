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
            width: 80px;
            height: auto;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat p {
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
        }
        th, td {
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
            <img src="{{ asset('storage\app\public\bukti\9OZggbXpAW1hD4Q5afGA987AIQe4BPDTmpbjvXRG.png') }}" alt="Logo Kiri">
            <div>
                <h1>KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h1>
                <h2>POLITEKNIK NEGERI CILACAP</h2>
                <p>PENCEGAHAN DAN PENANGANAN KEKERASAN SEKSUAL</p>
                <p>Jalan Dr. Soetomo No. 1, Sidakaya - CILACAP 53212 Jawa Tengah</p>
                <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
                <p>www.pnc.ac.id, Email: sekretariat@pnc.ac.id</p>
            </div>
            <img src="{{ asset('images/logo2.png') }}" alt="Logo Kanan">
        </div>
        <div class="line"></div>
        <p>FORM PELAPORAN KASUS KEKERASAN SEKSUAL</p>
        <p>SATUAN TUGAS PPKS POLITEKNIK NEGERI CILACAP</p>
    </div>
    <div class="content">
        <h2>Detail Pelaporan</h2>
        <table>
            <tr>
                <th>ID</th>
                <td>{{ $pelaporan->id }}</td>
            </tr>
            <tr>
                <th>ID User</th>
                <td>{{ $pelaporan->user_id }}</td>
            </tr>
            <tr>
                <th>Nama Pelapor</th>
                <td>{{ $pelaporan->nama_pelapor }}</td>
            </tr>
            <tr>
                <th>Melapor Sebagai</th>
                <td>{{ $pelaporan->melapor_sebagai }}</td>
            </tr>
            <tr>
                <th>Nomor HP</th>
                <td>{{ $pelaporan->nomor_hp }}</td>
            </tr>
            <tr>
                <th>Alamat Email</th>
                <td>{{ $pelaporan->alamat_email }}</td>
            </tr>
            <tr>
                <th>Domisili Pelapor</th>
                <td>{{ $pelaporan->domisili_pelapor }}</td>
            </tr>
            <tr>
                <th>Jenis Kekerasan Seksual</th>
                <td>{{ $pelaporan->jenis_kekerasan_seksual }}</td>
            </tr>
            <tr>
                <th>Cerita Peristiwa</th>
                <td>{{ $pelaporan->cerita_peristiwa }}</td>
            </tr>
            <tr>
                <th>Memiliki Disabilitas</th>
                <td>{{ $pelaporan->memiliki_disabilitas }}</td>
            </tr>
            <tr>
                <th>Deskripsi Disabilitas</th>
                <td>{{ $pelaporan->deskripsi_disabilitas }}</td>
            </tr>
            <tr>
                <th>Status Terlapor</th>
                <td>{{ $pelaporan->status_terlapor }}</td>
            </tr>
            <tr>
                <th>Alasan Pengaduan</th>
                <td>{{ $pelaporan->alasan_pengaduan }}</td>
            </tr>
            <tr>
                <th>Nomor HP Pihak Lain</th>
                <td>{{ $pelaporan->nomor_hp_pihak_lain }}</td>
            </tr>
            <tr>
                <th>Kebutuhan Korban</th>
                <td>{{ $pelaporan->kebutuhan_korban }}</td>
            </tr>
            <tr>
                <th>Tanggal Pelaporan</th>
                <td>{{ $pelaporan->tanggal_pelaporan }}</td>
            </tr>
            <tr>
                <th>Bukti</th>
                <img src="{{  }}" alt="">
            </tr>
            <tr>
                <th>Voice Note</th>
                <td>
                    @if ($pelaporan->voicenote)
                        <audio controls>
                            <source src="{{ asset('storage/' . $pelaporan->voicenote) }}" type="audio/webm">
                            Your browser does not support the audio element.
                        </audio>
                    @else
                        Tidak ada voice note yang diunggah.
                    @endif
                </td>
            </tr>
            <tr>
                <th>Respon</th>
                <td>{{ $pelaporan->respon }}</td>
            </tr>
        </table>
        <div class="signature">
            <p>Tanda Tangan:</p>
            @if ($pelaporan->bukti)
            <a href="{{ asset(Storage::url($pelaporan->bukti)) }}" target="_blank">Lihat Bukti</a>
        @else
            <p>Tidak ada bukti yang diunggah.</p>
        @endif
        </div>
        
    </div>
</body>
</html>
