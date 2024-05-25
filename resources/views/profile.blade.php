@extends('layouts.tampilansatgas')

@section('container')
    <div class="container my-4">
        <h1>Profile</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mt-4">
            <form action="{{ route('updateprofile', $user->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3 col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="npm_nidn_npak" class="form-label">NPM/NIDN/NPAK</label>
                    <input type="text" class="form-control" id="npm_nidn_npak" name="npm_nidn_npak"
                        value="{{ $user->npm_nidn_npak }}">
                    @error('npm_nidn_npak')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="mt-2 btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
