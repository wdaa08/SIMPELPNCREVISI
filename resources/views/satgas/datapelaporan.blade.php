@extends('layouts.tampilansatgas')

@section('container')
    <style>
        .thick-border-table th,
        .thick-border-table td {
            border: 2px solid #000;
            /* Sesuaikan ketebalan dan warna sesuai kebutuhan */
        }
    </style>

    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h1 style="text-align:center;">Data Laporan Masuk</h1>
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">
                        <form class="form-inline mb-4">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Cari">
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered thick-border-table text-nowrap">
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
                                        <th scope="col">Respon</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table">
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
                                            <td>
                                                <a href="{{ route('ttdview', ['id' => $item->id]) }}" type="button"
                                                    class="btn btn-primary">Lihat</a>
                                            </td>
                                            <td>
                                                <span>{{$item->respon}}</span>
                                            </td>
                                            <td>
                                                <a class="ml-3"
                                                    href="{{ route('s.editdatapelaporan', ['id' => $item->id]) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                                        width="24" height="24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            </td>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('s.datapelaporan.search') }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        $('#data-table').html(data);
                    }
                });
            });
        });
    </script>
@endsection
