@extends('layouts.tampilanpelapor')

@section('container')
<div class="container my-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-0">
            <div class="bg-light rounded h-100 p-4">
                <h1 class="card-title">Daftar Pelaporan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tabellaporan as $tbl)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>Pelaporan {{ $loop->iteration }}</td>
                        
                        <td>
                            <a href="{{ route('editlaporan', ['id' => $tbl->id]) }}" type="button"
                                class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            {{$tbl->respon}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
