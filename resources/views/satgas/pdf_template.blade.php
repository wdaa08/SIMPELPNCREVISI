<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Tambahkan gaya untuk korps surat di sini */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>Nama Perusahaan</h1>
        <p>Alamat Perusahaan</p>
        <p>Telepon: (123) 456-7890</p>
        <hr>
    </div>
    <div class="content">
        <!-- Konten surat -->
        @yield('content')
    </div>
</body>
</html>
