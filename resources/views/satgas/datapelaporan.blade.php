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
                                        <th scope="col">Tanggal Pelaporan</th>
                                        <th scope="col">Respon</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table">
                                    @foreach ($tabellaporan as $item)
                                        <tr>
                                            <td>{{ $item->nama_pelapor }}</td>
                                            <td>{{ $item->melapor_sebagai }}</td>
                                            <td>{{ $item->tanggal_pelaporan }}</td>
                                            {{-- <td> --}}
                                                {{-- <a href="{{ route('ttdview', ['id' => $item->id]) }}" type="button"
                                                    class="btn btn-primary">Lihat</a> --}}
                                                    {{-- {{ $item->tanda_tangan }} --}}
                                            {{-- </td> --}}

                                            
                                            <td>
                                                <span>{{$item->respon}}</span>
                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('s.editdatapelaporan', ['id' => $item->id]) }}" class="ml-3" style="background-color: red; color: white; padding: 5px 14px; border-radius: 2px;">
                                                    LIHAT
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
