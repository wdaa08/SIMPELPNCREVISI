@extends('layouts.tampilansatgas')

@section('container')
    <style>
        .thick-border-table th, .thick-border-table td {
            border: 2px solid #000; /* Adjust the thickness and color as needed */
        }
    </style>



    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered thick-border-table text-nowrap" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nama Pelaporan</th>
                                        <th scope="col">Melapor Sebagai</th>
                                        <th scope="col">Nomor Hp</th>
                                        <th scope="col">Alamat Email</th>
                                        <th scope="col">Domisili Pelapor</th>
                                        <th scope="col">Jenis Kekerasan Seksual</th>
                                        <th scope="col">Cerita Peristiwa</th>
                                        <th scope="col">Memiliki Disabilitas</th>
                                        <th scope="col">Deskripsi Disabilitas</th>
                                        <th scope="col">Status Terlapor</th>
                                        <th scope="col">Alasan Pengaduan</th>
                                        <th scope="col">Nomor HP Pihak Lain</th>
                                        <th scope="col">Kebutuhan Korban</th>
                                        <th scope="col">Tanggal Pelaporan</th>
                                        <th scope="col">Tanda Tangan Pelapor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabellaporan as $item)
                                    <tr>
                                        <td>{{ $item->nama_pelapor }}</td>
                                        <td>{{ $item->melapor_sebagai }}</td>
                                        <td>{{ $item->nomor_hp }}</td>
                                        <td>{{ $item->alamat_email }}</td>
                                        <td>{{ $item->domisili_pelapor }}</td>
                                        <td>{{ $item->jenis_kekerasan_seksual }}</td>
                                        <td>{{ $item->cerita_peristiwa }}</td>
                                        <td>{{ $item->memiliki_disabilitas }}</td>
                                        <td>{{ $item->deskripsi_disabilitas }}</td>
                                        <td>{{ $item->status_terlapor }}</td>
                                        <td>{{ $item->alasan_pengaduan }}</td>
                                        <td>{{ $item->nomor_hp_pihak_lain }}</td>
                                        <td>{{ $item->kebutuhan_korban }}</td>
                                        <td>{{ $item->tanggal_pelaporan }}</td>
                                        <td>{{ $item->tanda_tangan_pelapor }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
