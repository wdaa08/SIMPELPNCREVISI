@extends('layouts.tampilansatgas')

@section('container')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-6">
            <div class="bg-light rounded p-4">
                <h2 class="mb-4">Laporan Per Jurusan</h2>
                <canvas id="laporanPerJurusanChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-sm-6 col-xl-6">
            <div class="bg-light rounded p-4">
                <h2 class="mb-4">Laporan Per Program Studi</h2>
                <canvas id="laporanPerProdiChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="bg-light rounded p-4">
                <h2 class="mb-4">Laporan Per Bulan</h2>
                <ul class="list-unstyled">
                    @foreach ($laporanPerBulan as $laporan)
                        <li>{{ \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->translatedFormat('F Y') }}: {{ $laporan->total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="bg-light rounded ">
                <div class="card-body">
                    <h2 class="card-title mb-4">Status Terlapor</h2>
                    <ul class="list-unstyled">
                        @foreach ($statusTerlapor as $status)
                            <li>{{ $status->status_terlapor }}: {{ $status->total }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="bg-light rounded p-4">
                <h2 class="mb-4">Jumlah Pengguna dan Laporan</h2>
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Jumlah Pengguna: {{ $jumlahUser }}</h4>
                    </div>
                    <div class="col-sm-6">
                        <h4>Jumlah Laporan: {{ $jumlahLaporan }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Laporan Per Jurusan
    var ctxLaporanPerJurusan = document.getElementById('laporanPerJurusanChart').getContext('2d');
    var laporanPerJurusanChart = new Chart(ctxLaporanPerJurusan, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($laporanPerJurusan as $jurusan)
                    '{{ $jurusan->jurusan }}',
                @endforeach
            ],
            datasets: [{
                label: 'Total Laporan',
                data: [
                    @foreach ($laporanPerJurusan as $jurusan)
                        {{ $jurusan->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // Untuk menampilkan nilai tanpa koma desimal
                    }
                }
            }
        }
    });

    // Grafik Laporan Per Program Studi
    var ctxLaporanPerProdi = document.getElementById('laporanPerProdiChart').getContext('2d');
    var laporanPerProdiChart = new Chart(ctxLaporanPerProdi, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($laporanPerProdi as $prodi)
                    '{{ $prodi->prodi }}',
                @endforeach
            ],
            datasets: [{
                label: 'Total Laporan',
                data: [
                    @foreach ($laporanPerProdi as $prodi)
                        {{ $prodi->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // Untuk menampilkan nilai tanpa koma desimal
                    }
                }
            }
        }
    });
</script>

@endsection
