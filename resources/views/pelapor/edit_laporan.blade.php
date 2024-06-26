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

                            <label for="" class="form-label mt-3">Silahkan Narasikan Jenis Kekerasan Seksual </label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="narasipelapor" name="jenis_kekerasan_seksual" id="floatingTextarea"
                                    style="height: 150px;">{{ $pelapor->jenis_kekerasan_seksual }}</textarea>
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
                            <div class="form-floating mt-3" id="disabilityInput" style="display: @if ($pelapor->memiliki_disabilitas == 'memiliki') block @else none @endif;">
                                <input type="text" class="form-control" id="deskripsidisabilitas" name="deskripsi_disabilitas" placeholder="Deskripsi Disabilitas" value="{{ $pelapor->deskripsi_disabilitas }}">
                                <label for="deskripsidisabilitas">Deskripsi Disabilitas</label>
                            </div>
                            <div class="form-floating mb-3 mt-3">
                                <select class="form-select" id="statusterlapor" name="status_terlapor" aria-label="Floating label select example">
                                    <option value="">-- Pilih salah satu --</option>
                                    <option value="Mahasiswa" @if ($pelapor->status_terlapor == 'Mahasiswa') selected @endif>Mahasiswa</option>
                                    <option value="Pendidik" @if ($pelapor->status_terlapor == 'Pendidik') selected @endif>Pendidik</option>
                                    <option value="Tenaga Kependidikan" @if ($pelapor->status_terlapor == 'Tenaga Kependidikan') selected @endif>Tenaga Kependidikan</option>
                                    <option value="Warga Kampus" @if ($pelapor->status_terlapor == 'Warga Kampus') selected @endif>Warga Kampus</option>
                                    <option value="Masyarakat Umum" @if ($pelapor->status_terlapor == 'Masyarakat Umum') selected @endif>Masyarakat Umum</option>
                                </select>
                                <label for="statusterlapor">Status Terlapor:</label>
                            </div>
                            

                            <div class="border border-light p-3">
                                <div class="mb-3">
                                    <label for="alasanPengaduan" class="form-label">Silahkan centang salah satu atau lebih alasan pengaduan</label>
                                    @php
                                        // Inisialisasi opsi alasan pengaduan yang telah dipilih
                                        $alasanPengaduan = old('alasan_pengaduan', explode(', ', $pelapor->alasan_pengaduan));
                                    @endphp
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" id="khawatirKorban" value="Saya seorang saksi yang khawatir dengan keadaan korban" {{ in_array('Saya seorang saksi yang khawatir dengan keadaan korban', $alasanPengaduan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="khawatirKorban">
                                            Saya seorang saksi yang khawatir dengan keadaan korban
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" id="bantuanPemulihan" value="Saya seorang korban yang memerlukan bantuan pemulihan" {{ in_array('Saya seorang korban yang memerlukan bantuan pemulihan', $alasanPengaduan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bantuanPemulihan">
                                            Saya seorang korban yang memerlukan bantuan pemulihan
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" id="tindakTegasLaporan" value="Saya ingin perguruan tinggi menindak tegas terlapor" {{ in_array('Saya ingin perguruan tinggi menindak tegas terlapor', $alasanPengaduan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tindakTegasLaporan">
                                            Saya ingin perguruan tinggi menindak tegas terlapor
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" id="dokumentasiKejadian" value="Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya" {{ in_array('Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya', $alasanPengaduan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dokumentasiKejadian">
                                            Saya ingin satuan tugas mendokumentasikan kejadiannya, meningkatkan keamanan perguruan tinggi dari kekerasan seksual, dan memberi perlindungan bagi saya
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <label class="form-check-label" for="lainnya">Lainnya :</label>
                                        <input type="text" class="form-control" id="lainnyaInput" name="alasan_pengaduan[lainnya]" placeholder="Opsional" value="{{ $pelapor->lainnya }}">
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
            @php
                $kebutuhanKorban = explode(', ', $pelapor->kebutuhan_korban);
            @endphp
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="konselingPsikologis" value="Konseling Psikologis"
                    {{ in_array('Konseling Psikologis', $kebutuhanKorban) ? 'checked' : '' }}>
                <label class="form-check-label" for="konselingPsikologis">
                    Konseling Psikologis
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="konselingRohani" value="Konseling Rohani atau Spiritual"
                    {{ in_array('Konseling Rohani atau Spiritual', $kebutuhanKorban) ? 'checked' : '' }}>
                <label class="form-check-label" for="konselingRohani">
                    Konseling Rohani/Spiritual
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="bantuanHukum" value="Bantuan Hukum"
                    {{ in_array('Bantuan Hukum', $kebutuhanKorban) ? 'checked' : '' }}>
                <label class="form-check-label" for="bantuanHukum">
                    Bantuan Hukum
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="bantuanMedis" value="Bantuan Medis"
                    {{ in_array('Bantuan Medis', $kebutuhanKorban) ? 'checked' : '' }}>
                <label class="form-check-label" for="bantuanMedis">
                    Bantuan Medis
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="bantuanDigital" value="Bantuan Digital"
                    {{ in_array('Bantuan Digital', $kebutuhanKorban) ? 'checked' : '' }}>
                <label class="form-check-label" for="bantuanDigital">
                    Bantuan Digital
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="lainnya">Lainnya:</label>
                <input type="text" class="form-control" id="lainnya2Input" name="kebutuhan_korban[]" placeholder="Opsional"
                    value="{{ in_array('Lainnya', $kebutuhanKorban) ? $kebutuhanKorban[array_search('Lainnya', $kebutuhanKorban) + 1] : '' }}">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="kebutuhan_korban[]" id="tidakMembutuhkan" value="Tidak Membutuhkan Pendampingan"
                    {{ in_array('Tidak Membutuhkan Pendampingan', $kebutuhanKorban) ? 'checked' : '' }}>
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
        var checkboxesLainnya = document.querySelectorAll('input[name="kebutuhan_korban[]"]:not(#tidakMembutuhkan)');

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

        // Jika "Tidak Membutuhkan Pendampingan" sudah dicentang saat halaman dimuat
        if (checkboxTidakMembutuhkan.checked) {
            checkboxesLainnya.forEach(function(checkbox) {
                checkbox.disabled = true;
            });
        }
    </script>


                                <div class="mb-3">
                                    <label for="tanggal">Tanggal Pelaporan:</label>
                                    <input type="date" id="tanggalpelaporan" name="tanggal_pelaporan" value="{{ old('tanggal_pelaporan', $formattedDate) }}">
                                </div>

                                <label for="tanggal">Bukti: </label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="bukti" name="bukti">
                                    <label class="input-group-text" for="bukti" name="bukti">Upload</label>
                                </div>

                                <div class="form-group">
                                    <label for="voicenote">Rekam Suara:</label>
                                    <br>
                                    <button type="button" id="recordButton" class="btn btn-primary">Mulai Rekam</button>
                                    <button type="button" id="stopButton" class="btn btn-danger" disabled>Berhenti Rekam</button>
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
                                                                                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                                                                                mediaRecorder = new MediaRecorder(stream);
                                                                                
                                                                                mediaRecorder.ondataavailable = (event) => {
                                                                                    if (event.data.size > 0) {
                                                                                        recordedChunks.push(event.data);
                                                                                    }
                                                                                };
        
                                                                                mediaRecorder.onstop = () => {
                                                                                    const blob = new Blob(recordedChunks, { type: 'audio/wav' });
                                                                                    const url = URL.createObjectURL(blob);
                                                                                    
                                                                                    // Set audio preview
                                                                                    audioPreview.src = url;
                                                                                    audioPreview.style.display = 'block';
                                                                                    
                                                                                    // Set input file for form submission
                                                                                    const file = new File([blob], 'voicenote.wav', { type: 'audio/wav' });
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
