<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMPEL PNC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    

    <!-- Favicon -->
    @include('partials.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        {{-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> --}}
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

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i
                    class="bi bi-arrow-up"></i></a>
        </div>

        @include('partials.js')
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session('success'))
            Swal.fire({
            title: 'Pengaduan Berhasil Dikirim',
            text: '',
            icon: 'success',
            });
        @endif
        @if (Session('edit.success'))
            Swal.fire({
            title: 'edit Berhasil Dikirim',
            text: '',
            icon: 'success',
            });
        @endif
        @if (Session('error'))
            Swal.fire({
            title: 'Pengaduan Gagal Dikirim',
            text: '{{ session('error') }}',
            icon: 'error',
            });
            
        @endif 
         // Menampilkan pesan kesalahan validasi jika ada
         @if($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}<br>';
                @endforeach

                Swal.fire({
                    title: 'pengaduan gagal!',
                    html: `<div style="text-align: left;">${errorMessages}</div>`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif         

            @if (Session('success.edit.profil'))
            Swal.fire({
            title: 'Pengaduan Berhasil Dikirim',
            text: '',
            icon: 'success',
            });
        @endif


            
    </script>

    
    
</body>




</html>
