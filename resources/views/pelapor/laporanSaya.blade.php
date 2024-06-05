@extends('layouts.tampilanpelapor')

@section('container')
    <div class="container my-4">
        {{-- tabel pelaporan --}}
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
