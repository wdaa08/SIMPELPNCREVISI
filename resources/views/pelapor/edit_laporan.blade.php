@extends('layouts.tampilanpelapor')

@section('container')
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-0">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Formulir Pelaporan</h6>
                    <form method="post" action="{{ route('updatelaporan', $pelapor->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="namapelapor" class="form-label">Nama Pelapor</label>
                            <input type="text" class="form-control" id="namapelapor" name="nama_pelapor"
                                value="{{ $pelapor->nama_pelapor }}">
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="melaporsebagai" name="melapor_sebagai"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>-- pilih salah satu --</option>
                                <option value="korban" @if ($pelapor->melapor_sebagai == 'korban') selected @endif>Korban</option>
                                <option value="saksi" @if ($pelapor->melapor_sebagai == 'saksi') selected @endif>Saksi</option>
                            </select>
                            <label for="melaporsebagai">Melapor Sebagai:</label>
                        </div>

                        <div class="mb-3">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="nomorhp">Nomor HP</label>
                                <input type="number" id="nomorhp" name="nomor_hp" class="form-control"
                                    value="{{ $pelapor->nomor_hp }}" />
                                <script>
                                    document.getElementById("nomorhp").addEventListener("input", function() {
                                        var input = this.value.replace(/\s+/g, '');
                                        if (input.length > 14) {
                                            alert("Masukan maksimal 14 angka");
                                            this.setCustomValidity("Input harus memiliki panjang maksimal 14 angka.");
                                        } else {
                                            this.setCustomValidity("");
                                        }
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="alamat_email" name="alamat_email"
                                value="{{ $pelapor->alamat_email }}" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-3">
                            <label for="domisilipelapor" class="form-label">Domisili Pelapor</label>
                            <input type="text" class="form-control" id="domisilipelapor" name="domisili_pelapor"
                                value="{{ $pelapor->domisili_pelapor }}" aria-describedby="emailHelp">
                        </div>

                        <label for="" class="form-label">Jenis Kekerasan Seksual</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="narasipelapor" id="jenis_kekerasan_seksual" name="jenis_kekerasan_seksual"
                                style="height: 150px;">{{ $pelapor->jenis_kekerasan_seksual }}</textarea>
                            <label for="floatingTextarea">Silahkan Narasikan</label>
                        </div>

                        <label for="" class="form-label mt-3">Cerita Singkat Peristiwa</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="narasipelapor" name="cerita_peristiwa" id="floatingTextarea"
                                style="height: 150px;">{{ $pelapor->cerita_peristiwa }}</textarea>
                        </div>

                        <div class="form-floating mt-3">
                            <select class="form-select" id="hasDisability" name="memiliki_disabilitas"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>pilih salah satu</option>
                                <option value="tidak" @if ($pelapor->memiliki_disabilitas == 'tidak') selected @endif>Tidak
                                </option>
                                <option value="memiliki" @if ($pelapor->memiliki_disabilitas == 'memiliki') selected @endif>Memiliki
                                </option>
                            </select>
                            <label for="hasDisability">Memiliki Disabilitas?</label>
                        </div>

                        <div class="form-floating mt-3" id="disabilityInput" style="display: none;">
                            <input type="text" class="form-control" id="deskripsidisabilitas"
                                name="deskripsi_disabilitas" placeholder="Deskripsi Disabilitas">
                            <label for="disabilityDescription">Deskripsi Disabilitas</label>
                        </div>

                        <fieldset class="row mb-3 mt-3">
                            <legend class="col-form-label col-sm-10 pt-0">Status Terlapor (pilih salah satu) </legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_terlapor" id="mahasiswa"
                                        @if ($pelapor->status_terlapor == 'Mahasiswa') checked @endif value="Mahasiswa">
                                    <label class="form-check-label" for="mahasiswa">
                                        Mahasiswa
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_terlapor" id="pendidik" @if ($pelapor->status_terlapor == 'Pendidik') checked @endif
                                        value="Pendidik">
                                    <label class="form-check-label" for="pendidik">
                                        Pendidik
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_terlapor" @if ($pelapor->status_terlapor == 'Tenaga Kependidikan') checked @endif
                                        id="tenagaKependidikan" value="Tenaga Kependidikan">
                                    <label class="form-check-label" for="tenagaKependidikan">
                                        Tenaga Kependidikan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_terlapor"
                                        id="wargaKampus" value="Warga Kampus" @if ($pelapor->status_terlapor == 'Warga Kampus') checked @endif>
                                    <label class="form-check-label" for="wargaKampus">
                                        Warga Kampus
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_terlapor"
                                        id="masyarakatUmum" value="Masyarakat Umum" @if ($pelapor->status_terlapor == 'Masyarakat Umum') checked @endif>
                                    <label class="form-check-label" for="masyarakatUmum">
                                        Masyarakat Umum
                                    </label>
                                </div>
                            </div>

                            <div class="border border-light p-3">
                                <div class="mb-3">
                                    <label for="alasanPengaduan" class="form-label">Alasan Pengaduan</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                            id="saksi" value="Saya seorang saksi yang khawatir dengan keadaan korban" @if (is_array($pelapor->alasan_pengaduan) && in_array('Saya seorang saksi yang khawatir dengan keadaan korban', $pelapor->alasan_pengaduan)) 
                                            checked 
                                        @endif>
                                        <label class="form-check-label" for="saksi">
                                            Saya seorang saksi yang khawatir dengan keadaan korban
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                            id="korban" value="Saya seorang korban yang memerlukan bantuan pemulihan" @if (is_array($pelapor->alasan_pengaduan) && in_array('Saya seorang korban yang memerlukan bantuan pemulihan', $pelapor->alasan_pengaduan)) 
                                            checked 
                                        @endif>
                                        <label class="form-check-label" for="korban">
                                            Saya seorang korban yang memerlukan bantuan pemulihan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                            id="tindakTegas" value="Saya ingin perguruan tinggi menindak tegas terlapor">
                                        <label class="form-check-label" for="tindakTegas">
                                            Saya ingin perguruan tinggi menindak tegas terlapor
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                            id="dokumentasi"
                                            value="Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya">
                                        <label class="form-check-label " for="dokumentasi">
                                            Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan
                                            perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        {{-- <input class="form-check-input" type="checkbox" id="lainnya" value="lainnya"> --}}
                                        <label class="form-check-label" for="lainnya">Lainnya :</label>
                                        <input type="text" class="form-control" id="InputText"
                                            name="alasan_pengaduan[]" placeholder="Opsional">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="typeNumber">Nomor HP Pihak lain yang dapat
                                        dikonfirmasi</label>
                                    <input type="number" id="nomorhppihaklain" name="nomor_hp_pihak_lain"
                                        value="{{ $pelapor->nomor_hp_pihak_lain }}" class="form-control" />
                                </div>
                            </div>
                            <script>
                                document.getElementById("nomorhppihaklain").addEventListener("input", function() {
                                    var input = this.value.replace(/\s+/g, '');
                                    if (input.length > 14) {
                                        alert("Masukan maksimal 14 angka");
                                        this.setCustomValidity("Input harus memiliki panjang maksimal 14 angka.");
                                    } else {
                                        this.setCustomValidity("");
                                    }
                                });
                            </script>
                            <div class="border border-light p-3">
                                <div class="mb-3">
                                    <label for="kebutuhanKorban" class="form-label">Identifikasi Kebutuhan Korban:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]"
                                            id="konselingPsikologis" value="Konseling Psikologis">
                                        <label class="form-check-label" for="konselingPsikologis">
                                            Konseling Psikologis
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]"
                                            id="konselingRohani" value="Konseling Rohani atau Spiritual">
                                        <label class="form-check-label" for="konselingRohani">
                                            Konseling Rohani/Spiritual
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]"
                                            id="bantuanHukum" value="Bantuan Hukum">
                                        <label class="form-check-label" for="bantuanHukum">
                                            Bantuan Hukum
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]"
                                            id="bantuanMedis" value="Bantuan Medis">
                                        <label class="form-check-label " for="bantuanMedis">
                                            Bantuan Medis
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]"
                                            id="bantuanDigital" value="Bantuan Digital">
                                        <label class="form-check-label" for="bantuanDigital">
                                            Bantuan Digital
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="lainnya">Lainnya :</label>
                                        <input type="text" class="form-control" id="lainnya2Input"
                                            name="kebutuhan_korban[]" placeholder="Opsional">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kebutuhan_korban"
                                            id="tidakMembutuhkan" value="Tidak Membutuhkan Pendampingan">
                                        <label class="form-check-label" for="tidakMembutuhkan">
                                            Tidak Membutuhkan Pendampingan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <script>
                                // Mendapatkan referensi checkbox "Tidak Membutuhkan Pendampingan"
                                var checkboxTidakMembutuhkan = document.getElementById("tidakMembutuhkan");

                                // Mendapatkan referensi checkbox lainnya
                                var checkboxesLainnya = document.querySelectorAll('input[name="kebutuhan_korban"]:not(#tidakMembutuhkan)');

                                // Menambahkan event listener untuk checkbox "Tidak Membutuhkan Pendampingan"
                                checkboxTidakMembutuhkan.addEventListener('change', function() {
                                    // Jika checkbox "Tidak Membutuhkan Pendampingan" dicentang
                                    if (checkboxTidakMembutuhkan.checked) {
                                        // Mengatur semua checkbox lainnya menjadi tidak tercentang dan tidak dapat diubah
                                        checkboxesLainnya.forEach(function(checkbox) {
                                            checkbox.disabled = true;
                                            checkbox.checked = false;
                                        });
                                    } else {
                                        // Jika checkbox "Tidak Membutuhkan Pendampingan" tidak dicentang, mengatur checkbox lainnya agar bisa diubah
                                        checkboxesLainnya.forEach(function(checkbox) {
                                            checkbox.disabled = false;
                                        });
                                    }
                                });
                            </script>

                            <div class="mb-3">
                                <label for="tanggal">Tanggal Pelaporan:</label>
                                <input type="date" id="tanggalpelaporan" name="tanggal_pelaporan" value="{{ old('tanggal_pelaporan', $formattedDate) }}">
                            </div>

                            <div class="mb-3">
                                <label for="ttdpelapor" class="form-label">Tanda Tangan Pelapor</label>
                                <input class="form-control" name="tanda_tangan_pelapor" type="file" id="tanda_tangan_pelapor" multiple>
                            </div>



                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <button class="btn btn-danger" type="submit">Kirim Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Content End -->

<!-- Custom Script -->
{{-- js untuk konfirmasi disabilitas --}}
<script>
    function showDisabilityInput() {
        var selectValue = document.getElementById("hasDisability").value;
        var disabilityInput = document.getElementById("disabilityInput");

        if (selectValue === "memiliki") {
            disabilityInput.style.display = "block";
        } else {
            disabilityInput.style.display = "none";
        }
    }
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        });
    </script>
@endif
