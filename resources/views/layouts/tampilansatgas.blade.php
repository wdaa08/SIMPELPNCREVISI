<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SIMPEL PNC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="keywords">
    <meta content="" name="description">
    

    @include('partials.css')

</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        @include('partials.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('partials.navbar')
            <!-- Navbar End -->


            <!-- Form untuk pelaporan -->
            @yield('container')
            <!-- Content End -->

             <!-- Footer Start -->
             <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Willy Devin</a>, Satgas PPKS PNC. 
                        </div>

                    </div>
                </div>
            </div>
            <!-- Footer End -->
          
        </div>

        <!-- JavaScript Libraries -->
        @include('partials.js')
    </div>


    <!-- Memuat SweetAlert2 dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- Bootstrap JS and any other JS dependencies -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <!-- Include any other JS files your layout depends on -->

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
        @if(Session::has('success'))
            Swal.fire({
                title: 'Pengguna baru berhasil',
                text: '',
                icon: 'success',
            });
        @endif

        @if(Session::has('edit.success'))
            Swal.fire({
                title: 'Edit berhasil dikirim',
                text: '',
                icon: 'success',
            });
        @endif

        @if(Session::has('error'))
            Swal.fire({
                title: 'Pengaduan gagal dikirim',
                text: '{{ session('error') }}',
                icon: 'error',
            });
        @endif

        @if(Session::has('successstatus'))
            Swal.fire({
                title: 'Status berhasil diubah',
                text: '',
                icon: 'success',
            });
        @endif

        @if(Session::has('successaddchatbot'))
            Swal.fire({
                title: 'Berhasil',
                text: '',
                icon: 'success',
            });
        @endif

        @if(Session::has('errortambah1data'))
            Swal.fire({
                title: 'Pengguna gagal ditambahkan',
                text: '{{ session('errortambah1data') }}',
                icon: 'error',
            });
        @endif

                @if (Session('successhapusdata'))
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('successhapusdata') }}',
                icon: 'success',
            });
        @endif

        @if (Session('warning'))
            Swal.fire({
                title: 'Peringatan',
                text: '{{ session('warning') }}',
                icon: 'warning',
            });
        @endif


        // Menampilkan pesan kesalahan validasi jika ada
        @if($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}<br>';
            @endforeach

            Swal.fire({
                title: 'Gagal!',
                html: `<div style="text-align: left;">${errorMessages}</div>`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
         
 </script>
</body>

</html>
