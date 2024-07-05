@extends('layouts.tampilanpelapor')

@section('container')
<div class="container my-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-0">
            <div class="bg-light rounded h-100 p-4">
                <h3 class="card-title">Daftar Pengaduan Saya</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">no</th>
                            <th scope="col">Jenis Kekerasan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Respon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tabellaporan as $tbl)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $tbl->jenis_kekerasan_seksual }}</td>
                            <td>{{ $tbl->tanggal_pelaporan }}</td>
                            <td>
                                @if($tbl->selesai === 'belum')
                                <span class="badge bg-danger">Belum</span> <!-- Warna merah untuk "belum" -->
                                @elseif($tbl->selesai === 'selesai')
                                <span class="badge bg-warning text-dark">Selesai</span>
                                <!-- Warna kuning untuk "selesai" -->
                                @endif
                            </td>
                            <td>{{ $tbl->respon }}</td>
                            <td>
                                @if($tbl->selesai === 'belum')
                                <a href="{{ route('editlaporan', ['id' => $tbl->id]) }}" type="button" class="btn btn-primary btn-sm btn-icon">
                                    <i class="fas fa-pencil-alt"></i> <!-- Icon pensil -->
                                </a>
                                @endif

                                <a href="#" type="button" class="btn btn-info btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#detailModal{{$tbl->id}}">
                                    <i class="far fa-eye"></i> <!-- Icon mata -->
                                </a>
                                
                                <!-- Formulir untuk menyelesaikan pelaporan -->
                                @if($tbl->selesai === 'belum')
                                <form action="{{ route('pelaporans.selesai', $tbl->id) }}" method="POST" class="selesai-form" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm btn-icon">
                                        <i class="fas fa-check"></i> <!-- Ikon Selesai -->
                                    </button>
                                </form>
                                @endif

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{$tbl->id}}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{$tbl->id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{$tbl->id}}">Detail
                                                    Pelaporan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Jenis Kekerasan:</strong> {{ $tbl->jenis_kekerasan_seksual }}
                                                </p>
                                                <p><strong>Tanggal Pelaporan:</strong> {{ $tbl->tanggal_pelaporan }}</p>
                                                <p><strong>Cerita Peristiwa:</strong> {{ $tbl->cerita_peristiwa }}</p>
                                                <p><strong>Memiliki Disabilitas:</strong> {{ $tbl->memiliki_disabilitas
                                                    }}</p>
                                                @if ($tbl->memiliki_disabilitas == 'memiliki')
                                                <p><strong>Deskripsi Disabilitas:</strong> {{
                                                    $tbl->deskripsi_disabilitas }}</p>
                                                @endif
                                                <p><strong>Status terlapor:</strong> {{ $tbl->status_terlapor }}</p>
                                                <p><strong>Alasan Pengaduan:</strong> {{ $tbl->alasan_pengaduan }}</p>
                                                <p><strong>Nomor HP pihak lain:</strong> {{ $tbl->nomor_hp_pihak_lain }}
                                                </p>
                                                <p><strong>Kebutuhan Korban:</strong> {{ $tbl->kebutuhan_korban }}</p>
                                                <p><strong>Bukti Foto:</strong> {!! $tbl->bukti ? '<img
                                                        src="'. asset('storage/' . $tbl->bukti) .'" width="100"
                                                        height="100" alt="Bukti">' : 'Tidak ada bukti foto yang
                                                    diunggah.' !!}</p>
                                                <p><strong>Bukti Video:</strong> {!! $tbl->video ? '<video width="320"
                                                        height="240" controls>
                                                        <source src="' . asset('storage/' . $tbl->video) . '"
                                                            type="video/mp4">Your browser does not support the video
                                                        tag.
                                                    </video>' : 'Tidak ada bukti video yang diunggah.' !!}</p>
                                                <p><strong>Rekaman Suara:</strong> {!! $tbl->voicenote ? '<audio
                                                        controls>
                                                        <source src="' . asset('storage/' . $tbl->voicenote) . '"
                                                            type="audio/webm">Your browser does not support the audio
                                                        element.
                                                    </audio>' : 'Tidak ada voice note yang diunggah.' !!}</p>
                                                <p><strong>Keterangan:</strong> {{ $tbl->respon }}</p>
                                                <!-- Tambahkan detail lainnya sesuai kebutuhan -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Tampilkan link halaman -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var selesaiForms = document.querySelectorAll('form.selesai-form');
        selesaiForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Cegah form submit otomatis
                var submitButton = form.querySelector('button[type="submit"]');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak dapat mengembalikan status ini setelah diubah!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ubah!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitButton.disabled = true; // Nonaktifkan tombol "Selesai"
                        form.submit(); // Lanjutkan form submit
                    }
                });
            });
        });
    });
</script>

@endsection
