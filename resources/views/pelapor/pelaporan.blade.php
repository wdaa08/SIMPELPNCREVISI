@extends('layouts.tampilanpelapor')

@section('container')
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-0">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Formulir Pelaporan</h6>
                    <form method="post" action="{{ route('tambah_laporan') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="namapelapor" class="form-label">Nama Pelapor</label>
                            <input type="text" class="form-control" id="namapelapor" name="nama_pelapor">
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="melaporsebagai" name="melapor_sebagai"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>-- pilih salah satu --</option>
                                <option value="korban">Korban</option>
                                <option value="saksi">Saksi</option>
                            </select>
                            <label for="melaporsebagai">Melapor Sebagai:</label>
                        </div>

                        <div class="mb-3">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="nomorhp">Nomor HP</label>
                                <input type="number" id="nomorhp" name="nomor_hp" class="form-control" />
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
                                aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-3">
                            <label for="domisilipelapor" class="form-label">Domisili Pelapor</label>
                            <input type="text" class="form-control" id="domisilipelapor" name="domisili_pelapor"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="melaporsebagai" name="melapor_sebagai"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>-- pilih salah satu --</option>
                                <option value="jeniskekerasan1">Menyampaikan ujaran yang mendiskriminasi atau melecehkan tampilan fisik, kondisi tubuh, dan/atau identitas gender Korban</option>
                                <option value="jeniskekerasan2">Memperlihatkan alat kelaminnya dengan sengaja tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan3">Menyampaikan ucapan yang memuat rayuan, lelucon, dan/atau siulan yang bernuansa seksual pada Korban</option>
                                <option value="jeniskekerasan4">Menatap Korban dengan nuansa seksual dan/atau tidak nyaman</option>
                                <option value="jeniskekerasan5">Mengirimkan pesan, lelucon, gambar, foto, audio, dan/atau video bernuansa seksual kepada Korban meskipun sudah dilarang Korban</option>
                                <option value="jeniskekerasan6">Mengambil, merekam, dan/atau mengedarkan foto dan/atau rekaman audio dan/atau visual Korban yang bernuansa seksual tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan7">Mengunggah foto tubuh dan/atau informasi pribadi Korban yang bernuansa seksual tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan8">Menyebarkan informasi terkait tubuh dan/atau pribadi Korban yang bernuansa seksual tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan9">Mengintip atau dengan sengaja melihat Korban yang sedang melakukan kegiatan secara pribadi dan/atau pada ruang yang bersifat pribadi</option>
                                <option value="jeniskekerasan10">Membujuk, menjanjikan, menawarkan sesuatu, atau mengancam Korban untuk melakukan transaksi atau kegiatan seksual yang tidak disetujui oleh Korban</option>
                                <option value="jeniskekerasan11">Memberi hukuman atau sanksi yang bernuansa seksual</option>
                                <option value="jeniskekerasan12">Menyentuh, mengusap, meraba, memegang, memeluk, mencium dan/atau menggosokkan bagian tubuhnya pada tubuh Korban tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan13">Membuka pakaian Korban tanpa persetujuan Korban</option>
                                <option value="jeniskekerasan14">Memaksa Korban untuk melakukan transaksi atau kegiatan seksual</option>
                                <option value="jeniskekerasan15">Mempraktikkan budaya komunitas Mahasiswa, Pendidik, dan Tenaga Kependidikan yang bernuansa Kekerasan Seksual</option>
                                <option value="jeniskekerasan16">Melakukan percobaan perkosaan, namun penetrasi tidak terjadi</option>
                                <option value="jeniskekerasan17">Melakukan perkosaan termasuk penetrasi dengan benda atau bagian tubuh selain alat kelamin</option>
                                <option value="jeniskekerasan18">Memaksa atau memperdayai Korban untuk melakukan aborsi</option>
                                <option value="jeniskekerasan19">Memaksa atau memperdayai Korban untuk hamil</option>
                                <option value="jeniskekerasan20">Membiarkan terjadinya Kekerasan Seksual dengan sengaja</option>
                                <option value="jeniskekerasan21">Melakukan perbuatan Kekerasan Seksual lainnya</option>
                                
                            </select>
                            <label for="melaporsebagai">Jenis Kekerasan Seksual:</label>
                        </div>
                        <label for="" class="form-label mt-3">Cerita Singkat Peristiwa</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="narasipelapor" name="cerita_peristiwa" id="floatingTextarea"
                                style="height: 150px;"></textarea>
                        </div>

                        <div class="form-floating mt-3">
                            <select class="form-select" id="hasDisability" name="memiliki_disabilitas"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>pilih salah satu</option>
                                <option value="tidak">Tidak</option>
                                <option value="memiliki">Memiliki</option>
                            </select>
                            <label for="hasDisability">Memiliki Disabilitas?</label>
                        </div>

                        <div class="form-floating mt-3" id="disabilityInput" style="display: none;">
                            <input type="text" class="form-control" id="deskripsidisabilitas"
                                name="deskripsi_disabilitas" placeholder="Deskripsi Disabilitas">
                            <label for="disabilityDescription">Deskripsi Disabilitas</label>
                        </div>

                        <div class="form-floating mb-3 mt-3">
                            <select class="form-select" id="statusterlapor" name="statusterlapor"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                            <option selected>-- pilih salah satu --</option>
                                            <option value="Mahasiswa">Mahasiswa</option>
                                            <option value="Pendidik">Pendidik</option>
                                            <option value="tenaga_kependidikan">Tenaga Kependidikan</option>
                                            <option value="warga_kampus">Warga Kampus</option>
                                            <option value="masyarakat_kampus">Masyarakat Umum</option>
                            </select>
                            <label for="status terlapor">Melapor Sebagai:</label>
                        </div>

                                                        {{-- JavaScript untuk konfirmasi disabilitas --}}
                                <script>
                                    function showDisabilityInput() {
                                        var selectValue = document.getElementById("hasLainnya").value;
                                        var disabilityInput = document.getElementById("LainnyaInput");

                                        if (selectValue === "lainnya") {
                                            disabilityInput.style.display = "block";
                                        } else {
                                            disabilityInput.style.display = "none";
                                        }
                                    }
                                </script>

                            <div class="mb-3">
                                <label for="alsanpengaduan" class="form-label">Alasan Pengaduan</label>
                                <input type="text" class="form-control" id="alsanpengaduan" name="alasan_pengaduan"
                                    aria-describedby="emailHelp">
                            </div>
                                <div class="form-floating mt-3" id="LainnyaInput" style="display: none;">
                                    <input type="text" class="form-control" id="Lainnya" name="Lainnya" placeholder="Lainnya">
                                    <label for="Lainnya">Alasan Lainnya</label>
                                </div>


                            <div class="mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="typeNumber">Nomor HP Pihak lain yang dapat
                                        dikonfirmasi</label>
                                    <input type="number" id="nomorhppihaklain" name="nomor_hp_pihak_lain"
                                        class="form-control" />
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
                                <input type="date" id="tanggalpelaporan" name="tanggal_pelaporan">
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

    @if (session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@endif