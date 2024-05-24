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
                <h1 style="text-align:center;" >Data Pengguna Website SIMPEL PNC</h1>
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered thick-border-table text-nowrap" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">NPM NIDN NPK</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabelpengguna as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->npm_nidn_npak }}</td>
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
