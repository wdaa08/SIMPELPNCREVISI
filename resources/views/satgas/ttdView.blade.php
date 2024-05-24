@extends('layouts.tampilansatgas')

@section('container')
    <div class="container my-4">
        <h1>Tanda Tangan Pelapor</h1>
        <div class="mb-3">
            @if ($pelapor->tanda_tangan_pelapor)
                <img src="{{ asset('storage/' . $pelapor->tanda_tangan_pelapor) }}" alt="Tanda Tangan Pelapor"
                    class="img-fluid img-thumbnail">
            @else
                <p>Tanda tangan tidak ditemukan.</p>
            @endif
        </div>
        <div class="mb-3 d-flex items-center justify-content-center">
            <a href="{{ route('s.datapelaporan') }}" type="button" class="btn btn-primary">Kembali</a>
        </div>
    </div>
@endsection
