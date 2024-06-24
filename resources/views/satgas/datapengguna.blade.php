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
                <h1 style="text-align:center;">Data Pengguna Website SIMPEL PNC</h1>
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#importModal">
                            <i class="fas fa-file-import"></i> Tambah
                        </button>
                        <button type="button" class="btn btn-success mb-3" onclick="window.location='{{ route('users.export') }}'">
                            <i class="fas fa-file-export"></i> Unduh
                        </button>
                        
                        

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered thick-border-table text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">NPM NIDN NPK</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabelpengguna as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->npm_nidn_npak }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @if ($item->tanda_tangan)
                                                <img src="{{ asset('storage/' . $item->tanda_tangan) }}" alt="Tanda Tangan" class="center-image" width="100" height="100">
                                            @else
                                                Tidak ada tanda tangan
                                            @endif
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

    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Impor Pengguna dari Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.import.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File Excel</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Impor Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
