@extends('layouts.tampilansatgas')

@section('container')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="d-flex justify-content-start mb-4">
                <a href="{{ route('dashboard.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf me-2"></i>Cetak Laporan PDF</a>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Laporan Per Jurusan</h4>
                <canvas id="laporanPerJurusanChart" width="400" height="300"></canvas>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Laporan Per Program Studi</h4>
                <canvas id="laporanPerProdiChart" width="500" height="300"></canvas>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-calendar-alt me-2"></i>Laporan Per Bulan</h4>
                <canvas id="laporanPerBulanChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-6">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-exclamation-triangle me-2"></i>Terlapor</h4>
                <ul class="list-unstyled">
                    @foreach ($statusTerlapor as $status)
                        <li>{{ $status->status_terlapor }}: {{ $status->total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-shield-alt me-2"></i>Data Jenis Kekerasan Seksual</h4>
                <ul class="list-unstyled">
                    @foreach ($jenisKekerasanSeksual as $jks)
                        <li>{{ $jks->jenis_kekerasan_seksual }}: {{ $jks->total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-calendar-alt me-2"></i>Status Laporan</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar-alt me-2"></i>Bulan</th>
                                <th><i class="fas fa-calendar-alt me-2"></i>Tahun</th>
                                <th><i class="fas fa-chart-bar me-2"></i>Total</th>
                                <th><i class="fas fa-check-circle me-2"></i>Selesai</th>
                                <th><i class="fas fa-times-circle me-2"></i>Belum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanPerBulan as $index => $laporan)
                            <tr>
                                <td>{{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }}</td>
                                <td>{{ $laporan->tahun }}</td>
                                <td>{{ $laporan->total }}</td>
                                <td>{{ $laporan->selesai_count }}</td>
                                <td>{{ $laporan->belum_count }}</td>
                            </tr>
                            @endforeach                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4"><i class="fas fa-users me-2"></i>Jumlah Pengguna dan Laporan</h4>
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
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
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
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Grafik Laporan Per Bulan
    document.addEventListener("DOMContentLoaded", function() {
        var laporanPerBulanData = @json($laporanPerBulan);
        
        var labels = laporanPerBulanData.map(function(item) {
            return item.tahun + '-' + item.bulan;
        });

        var dataTotal = laporanPerBulanData.map(function(item) {
            return Math.round(item.total);
        });

        var ctx = document.getElementById('laporanPerBulanChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Laporan',
                    data: dataTotal,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    pointRadius: 6,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: 'rgba(54, 162, 235, 1)',
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>

<style>
    .card-body {
        overflow-x: auto;
    }
    canvas {
        width: 100% !important;
        height: 400px !important; /* Adjusted height */
    }
    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

@endsection
