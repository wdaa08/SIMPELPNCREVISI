@extends('layouts.tampilansatgas')

@section('container')
            <style>
                /* CSS untuk tabel dengan border tebal */
                .thick-border-table {
                    border-collapse: collapse;
                    width: 100%;
                }

                .thick-border-table th, .thick-border-table td {
                    border: 2px solid #000; /* Tebal dan warna garis sesuai kebutuhan */
                    padding: 8px; /* Padding untuk sel */
                    text-align: left; /* Penyusunan teks dalam sel */
                }

                .thick-border-table th {
                    background-color: #009CFF; /* Warna latar header */
                    color: rgb(0, 0, 0); /* Warna teks header */
                }

                .thick-border-table tr:nth-child(even) {
                    background-color: #f2f2f2; /* Warna latar baris genap */
                }

                .thick-border-table tr:hover {
                    background-color: #ddd; /* Warna latar saat hover */
                }

                .center-image {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                }
            </style>

            <div class="container my-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-0">
                        <div class="bg-light rounded h-100 p-4 table-responsive">
                            <h3 class="card-title">Data Laporan Masuk</h3>
                            <table class="table thick-border-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Respon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaporans as $index => $pelaporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pelaporan->tanggal_pelaporan }}</td>
                                        <td>{{ $pelaporan->nama_pelapor }}</td>
                                        <td>
                                            <span id="respon{{ $pelaporan->id }}">{{ $pelaporan->respon }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <button type="button" class="btn btn-warning edit-respon-btn"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-id="{{ $pelaporan->id }}">
                                                    <i class="fas fa-pencil-alt"></i> <!-- Ganti dengan ikon Edit -->
                                                </button>
                                                <button type="button" class="btn btn-primary detail-pelaporan-btn"
                                                    data-bs-toggle="modal" data-bs-target="#modalDetailPelaporan"
                                                    data-id="{{ $pelaporan->id }}">
                                                    <i class="fas fa-eye"></i> <!-- Ganti dengan ikon Eye -->
                                                </button>
                                                <a href="{{ route('pelaporans.cetakPdf', $pelaporan->id) }}"
                                                    class="btn btn-danger">
                                                    <i class="fas fa-file-pdf"></i> <!-- Ganti dengan ikon PDF -->
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pelaporans->links() }}
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Pelaporan -->
                <div class="modal fade" id="modalDetailPelaporan" tabindex="-1" aria-labelledby="modalDetailPelaporanLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailPelaporanLabel">Detail Pelaporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <tbody id="modalDetailBody">
                                        <!-- Data pelaporan akan dimuat di sini secara dinamis -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Ubah Respon -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ubah Respon</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditRespon">
                                    <div class="mb-3">
                                        <label for="responInput" class="form-label">Respon:</label>
                                        <textarea class="form-control" id="responInput" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" id="pelaporanId" name="pelaporanId" value="">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="simpanResponBtn">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Modal Detail Pelaporan -->
        <div class="modal fade" id="modalDetailPelaporan" tabindex="-1" aria-labelledby="modalDetailPelaporanLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailPelaporanLabel">Detail Pelaporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody id="modalDetailBody">
                                <!-- Data pelaporan akan dimuat di sini secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Respon -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Respon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditRespon">
                            <div class="mb-3">
                                <label for="responInput" class="form-label">Respon:</label>
                                <textarea class="form-control" id="responInput" rows="3"></textarea>
                            </div>
                            <input type="hidden" id="pelaporanId" name="pelaporanId" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanResponBtn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editResponButtons = document.querySelectorAll('.edit-respon-btn');
            var detailPelaporanButtons = document.querySelectorAll('.detail-pelaporan-btn');
            var modalResponInput = document.getElementById('responInput');
            var simpanResponBtn = document.getElementById('simpanResponBtn');
            var pelaporanIdField = document.getElementById('pelaporanId');
            var modalDetailBody = document.getElementById('modalDetailBody');

            editResponButtons.forEach(button => {
                button.addEventListener('click', function() {
                    var pelaporanId = this.getAttribute('data-id');
                    pelaporanIdField.value = pelaporanId;
                    var currentRespon = document.getElementById('respon' + pelaporanId).textContent;
                    modalResponInput.value = currentRespon;
                });
            });


            detailPelaporanButtons.forEach(button => {
                button.addEventListener('click', function() {
                    var pelaporanId = this.getAttribute('data-id');

                    // Fetch data detail pelaporan
                    fetch(`/pelaporans/${pelaporanId}`)
                        .then(response => response.json())
                        .then(data => {
                            modalDetailBody.innerHTML = `
                            <tr>
                                <th scope="row">ID</th>
                                <td>${data.id}</td>
                            </tr>
                            <tr>
                                <th scope="row">ID User</th>
                                <td>${data.user_id}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Pelapor</th>
                                <td>${data.nama_pelapor}</td>
                            </tr>
                            <tr>
                                <th scope="row">Melapor Sebagai</th>
                                <td>${data.melapor_sebagai}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nomor HP</th>
                                <td>${data.nomor_hp}</td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat Email</th>
                                <td>${data.alamat_email}</td>
                            </tr>
                            <tr>
                                <th scope="row">Domisili Pelapor</th>
                                <td>${data.domisili_pelapor}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Kekerasan Seksual</th>
                                <td>${data.jenis_kekerasan_seksual}</td>
                            </tr>
                            <tr>
                                <th scope="row">Cerita Peristiwa</th>
                                <td>${data.cerita_peristiwa}</td>
                            </tr>
                            <tr>
                                <th scope="row">Memiliki Disabilitas</th>
                                <td>${data.memiliki_disabilitas}</td>
                            </tr>
                            <tr>
                                <th scope="row">Deskripsi Disabilitas</th>
                                <td>${data.deskripsi_disabilitas}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status Terlapor</th>
                                <td>${data.status_terlapor}</td>
                            </tr>
                            <tr>
                                <th scope="row">Alasan Pengaduan</th>
                                <td>${data.alasan_pengaduan}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nomor HP Pihak Lain</th>
                                <td>${data.nomor_hp_pihak_lain}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kebutuhan Korban</th>
                                <td>${data.kebutuhan_korban}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Pelaporan</th>
                                <td>${data.tanggal_pelaporan}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bukti</th>
                                <td>${data.bukti ? `<img src="/storage/${data.bukti}" width="100" height="100" alt="TTD">` : 'Tidak ada bukti yang diunggah.'}</td>
                            </tr>
                                 <tr>
                                <th class="mb-3" colspan="2">
                                    <label for="detailVoiceNote" class="form-label">Voice Note:</label><br>
                                    ${data.voicenote ? `<audio controls><source src="/storage/${data.voicenote}" type="audio/webm">Your browser does not support the audio element.</audio>` : 'Tidak ada voice note yang diunggah.'}
                                </th> 
                            </tr>

                            <tr>
                                <th scope="row">Respon</th>
                                <td>${data.respon}</td>
                            </tr>
                        `;
                        });
                });
            });
            simpanResponBtn.addEventListener('click', function() {
                var pelaporanId = pelaporanIdField.value;
                var updatedRespon = modalResponInput.value;

                fetch(`/pelaporans/${pelaporanId}/updateRespon`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            respon: updatedRespon
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('respon' + pelaporanId).textContent = data.respon;
                        var exampleModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        exampleModal.hide();

                        // Tampilkan SweetAlert2 untuk memberitahu berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Respon berhasil diperbarui.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat memperbarui respon.',
                        });
                    });
            });
        });
    </script>
@endsection
