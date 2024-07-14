@extends('layouts.tampilansatgas')

@section('container')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h1 style="text-align:center;">Data Pengguna Website SIMPEL PNC</h1>
                <div class="card shadow" style="box-shadow: 5px 5px 10px rgba(135, 110, 210, 0.5);">
                    <div class="card-body">

                        <!-- Button trigger modal for Import -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#importModal">
                            <i class="fas fa-file-excel"></i> Tambah
                        </button>

                        <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#addUserModal">
                            <i class="fas fa-user"></i> Tambah
                        </button>

                        <button type="button" class="btn btn-success mb-3" onclick="window.location='{{ route('users.export') }}'">
                            <i class="fas fa-download"></i> Unduh
                        </button>

                        <!-- Form for Deleting Users by Year -->
                        <form action="{{ route('users.deleteByYear') }}" method="POST" class="mb-3" id="deleteForm">
                            @csrf
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" id="deleteButton">
                                <i class="fas fa-trash"></i> Hapus Pengguna
                            </button>
                        </form>

                        <!-- Filter Dropdown -->
                        <div class="form-group">
                            {{-- <label for="roleFilter">Filter Berdasarkan Role:</label> --}}
                            <select class="form-control w-25" id="roleFilter">
                                <option value="all">--semua--</option>
                                <option value="1">SATGAS</option>
                                <option value="2">PELAPOR</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">NPM NIDN NPK</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Unit Kerja</th>
                                        <th scope="col">Jurusan</th>
                                        <th scope="col">Program Studi</th>
                                        <th scope="col">Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabelpengguna as $key => $item)
                                        <tr data-role-id="{{ $item->role_id }}">
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->npm_nidn_npak }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->unit_kerja }}</td>
                                            <td>{{ $item->jurusan }}</td>
                                            <td>{{ $item->prodi }}</td>
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

    <!-- Modal for Import -->
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

    <!-- Modal for Add User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="npm_nidn_npak">NPM/NIDN/NPAK</label>
                            <input type="text" class="form-control" id="npm_nidn_npak" name="npm_nidn_npak" value="{{ old('npm_nidn_npak') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nomorhp">Nomor HP</label>
                            <input type="text" class="form-control" id="nomorhp" name="nomorhp" value="{{ old('nomorhp') }}">
                        </div>
                        <div class="form-group">
                            <label for="domisili">Domisili</label>
                            <input type="text" class="form-control" id="domisili" name="domisili" value="{{ old('domisili') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="unit_kerja">Unit Kerja</label>
                            <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" id="prodi" name="prodi" value="{{ old('prodi') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="1">SATGAS</option>
                                <option value="2">PELAPOR</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Deleting Users by Year -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Pengguna Berdasarkan Tahun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.deleteByYear') }}" method="POST" id="deleteFormModal">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="year">Masukkan Tahun:</label>
                            <input type="text" class="form-control" id="year" name="year">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil elemen select
            const roleFilter = document.getElementById('roleFilter');

            // Tambahkan event listener untuk perubahan nilai
            roleFilter.addEventListener('change', function () {
                const selectedRoleId = roleFilter.value;

                // Ambil semua baris dalam tabel
                const rows = document.querySelectorAll('#dataTable tbody tr');

                // Iterasi setiap baris untuk menentukan apakah harus ditampilkan atau disembunyikan
                rows.forEach(row => {
                    const role_id = row.getAttribute('data-role-id');
                    
                    if (selectedRoleId === 'all' || role_id === selectedRoleId) {
                        row.style.display = ''; // Tampilkan baris
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                });
            });
        });
    </script>

@endsection
