@extends('layouts.tampilanpelapor')

@section('container')
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-0">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Formulir Pengaduan</h6>
                    <form method="post" action="{{ route('tambah_laporan') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="namapelapor" class="form-label">Nama Pelapor*</label>
                            <input type="text" class="form-control" id="namapelapor" name="nama_pelapor"
                                value="{{ auth()->user()->nama }}" disabled>
                            <input type="hidden" name="nama_pelapor" value="{{ auth()->user()->nama }}">
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="melaporsebagai" name="melapor_sebagai"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option selected>-- pilih salah satu --</option>
                                <option value="korban">Korban</option>
                                <option value="saksi">Saksi</option>
                            </select>
                            <label for="melaporsebagai">Melapor Sebagai:*</label>
                        </div>

                        <div class="mb-3">
                            <label for="nomorhp" class="form-label">Nomor HP*</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                value="{{ auth()->user()->nomorhp }}" disabled>
                            <input type="hidden" name="nomor_hp" value="{{ auth()->user()->nomorhp }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat_email" class="form-label">Alamat Email*</label>
                            <input type="email" class="form-control" id="alamat_email_disabled"
                                aria-describedby="emailHelp" value="{{ auth()->user()->email }}" disabled>
                            <!-- Input dinonaktifkan tetapi nilai akan dikirim ke server -->
                            <input type="hidden" name="alamat_email" value="{{ auth()->user()->email }}">
                            <!-- Input tersembunyi untuk menyimpan nilai yang akan dikirim ke server -->
                        </div>

                        <div class="mb-3">
                            <label for="nomorhp" class="form-label">Domisili*</label>
                            <input type="text" class="form-control" id="domisili_pelapor" name="domisili_pelapor"
                                value="{{ auth()->user()->domisili }}" disabled>
                            <input type="hidden" name="domisili_pelapor" value="{{ auth()->user()->domisili }}">
                        </div>

                        <label for="jenis_kekerasan_seksual" class="form-label mt-3">Jenis Kekerasan Seksual*</label>
                        <select class="form-select" name="jenis_kekerasan_seksual" id="jenis_kekerasan_seksual">
                            <option value="">--Pilih Salah Satu--</option>
                            <option value="Ujaran diskriminatif atau melecehkan Korban">Ujaran diskriminatif atau melecehkan Korban</option>
                            <option value="Memperlihatkan alat kelamin tanpa izin">Memperlihatkan alat kelamin tanpa izin</option>
                            <option value="Ucapan rayuan atau lelucon seksual">Ucapan rayuan atau lelucon seksual</option>
                            <option value="Menatap dengan nuansa seksual">Menatap dengan nuansa seksual</option>
                            <option value="Mengirim pesan atau media seksual">Mengirim pesan atau media seksual</option>
                            <option value="Mengambil atau mengedarkan foto/video seksual">Mengambil atau mengedarkan foto/video seksual</option>
                            <option value="Mengunggah foto atau info pribadi">Mengunggah foto atau info pribadi</option>
                            <option value="Menyebar info seksual tanpa izin">Menyebar info seksual tanpa izin</option>
                            <option value="Mengintip Korban tanpa izin">Mengintip Korban tanpa izin</option>
                            <option value="Membujuk atau mengancam untuk seks">Membujuk atau mengancam untuk seks</option>
                            <option value="Memberi sanksi seksual">Memberi sanksi seksual</option>
                            <option value="Menyentuh tubuh tanpa izin">Menyentuh tubuh tanpa izin</option>
                            <option value="Membuka pakaian tanpa izin">Membuka pakaian tanpa izin</option>
                            <option value="Memaksa transaksi seksual">Memaksa transaksi seksual</option>
                            <option value="Budaya komunitas berbasis seksual">Budaya komunitas berbasis seksual</option>
                            <option value="Percobaan perkosaan tanpa penetrasi">Percobaan perkosaan tanpa penetrasi</option>
                            <option value="Perkosaan dengan benda lain">Perkosaan dengan benda lain</option>
                            <option value="Memaksa aborsi">Memaksa aborsi</option>
                            <option value="Memaksa hamil">Memaksa hamil</option>
                            <option value="Membiarkan Kekerasan Seksual terjadi">Membiarkan Kekerasan Seksual terjadi</option>
                            <option value="Perbuatan Kekerasan Seksual lainnya">Perbuatan Kekerasan Seksual lainnya</option>
                        </select>
                        
                        <label for="" class="form-label mt-3">Cerita Singkat Peristiwa*</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="narasipelapor" name="cerita_peristiwa" id="floatingTextarea"
                                style="height: 150px;">{{ old('cerita_peristiwa') }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label for="voicenote">Voice Note | Optional</label>
                            <br>
                            <button type="button" id="recordButton" class="btn btn-primary">
                                <i class="fas fa-microphone-alt"></i> Mulai Rekam
                            </button>
                            <button type="button" id="stopButton" class="btn btn-danger" disabled>
                                <i class="fas fa-stop"></i> Berhenti Rekam
                            </button>
                            <input type="file" id="voicenote" name="voicenote" style="display: none;">
                            <p id="recordingTime">Durasi: 0s</p>
                            <audio id="audioPreview" controls style="display: none;"></audio>
                        </div>
                        
                        <script>
                            let mediaRecorder;
                            let recordedChunks = [];
                            let startTime;
                            let durationInterval;

                            const recordButton = document.getElementById('recordButton');
                            const stopButton = document.getElementById('stopButton');
                            const voiceInput = document.getElementById('voicenote');
                            const recordingTime = document.getElementById('recordingTime');
                            const audioPreview = document.getElementById('audioPreview');

                            recordButton.addEventListener('click', async () => {
                                try {
                                    const stream = await navigator.mediaDevices.getUserMedia({
                                        audio: true
                                    });
                                    mediaRecorder = new MediaRecorder(stream);

                                    mediaRecorder.ondataavailable = (event) => {
                                        if (event.data.size > 0) {
                                            recordedChunks.push(event.data);
                                        }
                                    };

                                    mediaRecorder.onstop = () => {
                                        const blob = new Blob(recordedChunks, {
                                            type: 'audio/wav'
                                        });
                                        const url = URL.createObjectURL(blob);

                                        // Set audio preview
                                        audioPreview.src = url;
                                        audioPreview.style.display = 'block';

                                        // Set input file for form submission
                                        const file = new File([blob], 'voicenote.wav', {
                                            type: 'audio/wav'
                                        });
                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(file);
                                        voiceInput.files = dataTransfer.files;
                                    };

                                    mediaRecorder.start();
                                    startTime = Date.now();
                                    durationInterval = setInterval(updateRecordingTime, 1000);
                                    recordingTime.textContent = 'Durasi: 0s';
                                    recordedChunks = [];

                                    recordButton.disabled = true;
                                    stopButton.disabled = false;
                                } catch (err) {
                                    console.error('Error accessing audio stream', err);
                                }
                            });

                            stopButton.addEventListener('click', () => {
                                if (mediaRecorder) {
                                    mediaRecorder.stop();
                                    clearInterval(durationInterval);
                                }

                                recordButton.disabled = false;
                                stopButton.disabled = true;
                            });

                            function updateRecordingTime() {
                                const duration = Math.floor((Date.now() - startTime) / 1000);
                                recordingTime.textContent = `Durasi: ${duration}s`;
                            }
                        </script>

                        <div class="form-floating mt-3">
                            <select class="form-select" id="hasDisability" name="memiliki_disabilitas"
                                aria-label="Floating label select example" onchange="showDisabilityInput()">
                                <option value="" disabled
                                    {{ old('memiliki_disabilitas') === null ? 'selected' : '' }}>pilih salah satu</option>
                                <option value="tidak" {{ old('memiliki_disabilitas') === 'tidak' ? 'selected' : '' }}>
                                    Tidak</option>
                                <option value="memiliki"
                                    {{ old('memiliki_disabilitas') === 'memiliki' ? 'selected' : '' }}>Memiliki</option>
                            </select>
                            <label for="hasDisability">Memiliki Disabilitas?*</label>
                        </div>


                        <div id="disabilityInput"
                            style="display: {{ old('memiliki_disabilitas') === 'memiliki' ? 'block' : 'none' }};">
                            <label for="deskripsi_disabilitas" class="form-label mt-3">Deskripsi Disabilitas</label>
                            <input type class="form-control" placeholder="Deskripsi disabilitas"
                                name="deskripsi_disabilitas" id="deskripsi_disabilitas"
                                style="height: 80px;">{{ old('deskripsi_disabilitas') }}</input>
                        </div>



                        <div class="form-floating mb-3 mt-3">
                            <select class="form-select" id="statusterlapor" name="status_terlapor"
                                aria-label="Floating label select example">
                                <option value="" disabled {{ old('status_terlapor') === null ? 'selected' : '' }}>--
                                    pilih salah satu --</option>
                                <option value="Mahasiswa" {{ old('status_terlapor') === 'Mahasiswa' ? 'selected' : '' }}>
                                    Mahasiswa</option>
                                <option value="Pendidik" {{ old('status_terlapor') === 'Pendidik' ? 'selected' : '' }}>
                                    Pendidik</option>
                                <option value="tenaga_kependidikan"
                                    {{ old('status_terlapor') === 'tenaga_kependidikan' ? 'selected' : '' }}>Tenaga
                                    Kependidikan</option>
                                <option value="warga_kampus"
                                    {{ old('status_terlapor') === 'warga_kampus' ? 'selected' : '' }}>Warga Kampus</option>
                                <option value="masyarakat_kampus"
                                    {{ old('status_terlapor') === 'masyarakat_kampus' ? 'selected' : '' }}>Masyarakat Umum
                                </option>
                            </select>
                            <label for="status terlapor">Status Terlapor:*</label>
                        </div>



                        <div class="border border-light p-3">
                            <div class="mb-3">
                                <label for="alasanPengaduan" class="form-label">Silahkan centang salah satu atau lebih
                                    alasan pengaduan*</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                        id="khawatirKorban" value="Saya seorang saksi yang khawatir dengan keadaan korban"
                                        {{ in_array('Saya seorang saksi yang khawatir dengan keadaan korban', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="khawatirKorban">
                                        Saya seorang saksi yang khawatir dengan keadaan korban
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                        id="bantuanPemulihan"
                                        value="Saya seorang korban yang memerlukan bantuan pemulihan"
                                        {{ in_array('Saya seorang korban yang memerlukan bantuan pemulihan', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bantuanPemulihan">
                                        Saya seorang korban yang memerlukan bantuan pemulihan
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                        id="tindakTegasLaporan"
                                        value="Saya ingin perguruan tinggi menindak tegas terlapor"
                                        {{ in_array('Saya ingin perguruan tinggi menindak tegas terlapor', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tindakTegasLaporan">
                                        Saya ingin perguruan tinggi menindak tegas terlapor
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]"
                                        id="dokumentasiKejadian"
                                        value="Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya"
                                        {{ in_array('Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dokumentasiKejadian">
                                        Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan
                                        perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label" for="lainnya">Lainnya :</label>
                                    <input type="text" class="form-control" id="lainnyaInput"
                                        name="alasan_pengaduan[lainnya]" placeholder="Opsional"
                                        value="{{ old('alasan_pengaduan.lainnya') }}">
                                </div>


                                <div class="mb-3">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="typeNumber">Nomor HP Pihak lain yang dapat
                                            dikonfirmasi</label>
                                        <input type="number" id="nomorhppihaklain" name="nomor_hp_pihak_lain"
                                            class="form-control" value="{{ old('nomor_hp_pihak_lain') }}" />
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
                                        <label for="kebutuhanKorban" class="form-label">Identifikasi Kebutuhan
                                            Korban:*</label>
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
                                    var checkboxTidakMembutuhkan = document.getElementById("tidakMembutuhkan");
                                    var checkboxesLainnya = document.querySelectorAll('input[name="kebutuhan_korban[]"]:not(#tidakMembutuhkan)');

                                    checkboxTidakMembutuhkan.addEventListener('change', function() {
                                        if (checkboxTidakMembutuhkan.checked) {
                                            checkboxesLainnya.forEach(function(checkbox) {
                                                checkbox.disabled = true;
                                                checkbox.checked = false;
                                            });
                                        } else {
                                            checkboxesLainnya.forEach(function(checkbox) {
                                                checkbox.disabled = false;
                                            });
                                        }
                                    });
                                </script>
                                <div class="mb-3">
                                    <label for="tanggal">Tanggal Pelaporan:*</label>
                                    <input type="date" id="tanggalpelaporan" name="tanggal_pelaporan">
                                </div>

                                <script>
                                    // Mendapatkan elemen input tanggal
                                    var inputTanggal = document.getElementById('tanggalpelaporan');

                                    // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
                                    var today = new Date().toISOString().split('T')[0];

                                    // Mengatur nilai default input tanggal ke tanggal hari ini
                                    inputTanggal.value = today;
                                </script>
                                <label for="bukti">Bukti Foto: </label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control-file" id="bukti" name="bukti" multiple>
                                </div>

                                <label for="video">Bukti Video: </label>
                                <div class="form-group mb-3">
                                    <input type="file" class="form-control-file" id="video" name="video" multiple>
                                </div>
                                <button class="btn btn-danger" type="submit">KIRIM PENGADUAN</button>
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

    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi showDisabilityInput() saat halaman dimuat untuk memeriksa nilai old()
        showDisabilityInput();
    });
</script>
