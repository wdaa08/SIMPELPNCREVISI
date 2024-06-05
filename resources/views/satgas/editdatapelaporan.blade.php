@extends('layouts.tampilansatgas')

@section('container')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h1 style="text-align:center;">Laporan</h1>
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">
                        <form action="{{route('s.updatedatapelaporan', $pelapor->id)}}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Nama Pelapor</label>
                                <input type="text" class="form-control" disabled id="namapelapor" name="nama_pelapor"
                                    value="{{ $pelapor->nama_pelapor }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Melapor Sebagai</label>
                                <input type="text" class="form-control" disabled id="melapor_sebagai"
                                    name="melapor_sebagai" value="{{ $pelapor->melapor_sebagai }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Nomor Hp</label>
                                <input type="text" class="form-control" disabled id="nomor_hp" name="nomor_hp"
                                    value="{{ $pelapor->nomor_hp }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Alamat Email</label>
                                <input type="text" class="form-control" disabled id="alamat_email" name="alamat_email"
                                    value="{{ $pelapor->alamat_email }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Domisili Pelapor</label>
                                <input type="text" class="form-control" disabled id="domisili_pelapor"
                                    name="domisili_pelapor" value="{{ $pelapor->domisili_pelapor }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Jenis Kekerasan Seksual</label>
                                <input type="text" class="form-control" disabled id="jenis_kekerasan_seksual"
                                    name="jenis_kekerasan_seksual" value="{{ $pelapor->jenis_kekerasan_seksual }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Cerita Peristiwa</label>
                                <input type="text" class="form-control" disabled id="cerita_peristiwa"
                                    name="cerita_peristiwa" value="{{ $pelapor->cerita_peristiwa }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Memiliki Disabilitas</label>
                                <input type="text" class="form-control" disabled id="memiliki_disabilitas"
                                    name="memiliki_disabilitas" value="{{ $pelapor->memiliki_disabilitas }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Deskripsi Disabilitas</label>
                                <input type="text" class="form-control" disabled id="deskripsi_disabilitas"
                                    name="deskripsi_disabilitas" value="{{ $pelapor->deskripsi_disabilitas }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Status Terlapor</label>
                                <input type="text" class="form-control" disabled id="status_terlapor"
                                    name="status_terlapor" value="{{ $pelapor->status_terlapor }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Nomor Hp Pihak Lain</label>
                                <input type="text" class="form-control" disabled id="nomor_hp_pihak_lain"
                                    name="nomor_hp_pihak_lain" value="{{ $pelapor->nomor_hp_pihak_lain }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Kebutuhan Korban</label>
                                <input type="text" class="form-control" disabled id="kebutuhan_korban"
                                    name="kebutuhan_korban" value="{{ $pelapor->kebutuhan_korban }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Tanggal Pelaporan</label>
                                <input type="text" class="form-control" disabled id=""
                                    name="tanggal_pelaporan" value="{{ $pelapor->tanggal_pelaporan }}">
                            </div>
                            <div class="mb-3">
                                <label for="namapelapor" class="form-label">Respon</label>
                                <select class="form-select" name="respon" id="respon">
                                    <option value="DI BACA" @if ($pelapor->respon == 'DI BACA') selected @endif>DI BACA
                                    </option>
                                    <option value="PENYELIDIKAN" @if ($pelapor->respon == 'PENYELIDIKAN') selected @endif>
                                        PENYELIDIKAN</option>
                                    <option value="SELESAI" @if ($pelapor->respon == 'SELESAI') selected @endif>SELESAI
                                    </option>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Edit Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
