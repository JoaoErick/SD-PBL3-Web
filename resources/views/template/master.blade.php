<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BikerGuard - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @yield('content-css')
</head>
<body style="background-color: #183153; height: 100vh">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #001c40">
        <div class="container-fluid">
            <a class="mx-3 navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/BikerGuard-icon.png') }}" width="40px" alt="">
                BikerGuard
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="">
                    Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">
                  Ajustes
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    
    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="mt-footer-custom">
        <footer class="footer-section fixed-bottom">
          <div class="container">
            <div class="row footer-row align-items-center justify-content-center">
              <div class="col-12 footer-col d-flex justify-content-center align-items-center">
                <a href="https://github.com/AllanCapistrano" target="_blank">
                  <i class="fab fa-github-square custom-item-size"></i> 
                  <span class="author-footer">Allan Capistrano</span>
                </a>
                <a href="https://github.com/JoaoErick" target="_blank">
                  <i class="fab fa-github-square custom-item-size"></i>
                  <span class="author-footer">João Erick Barbosa</span>
                </a>
              </div>
            </div>
          </div>
        </footer>
    </div>
    
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    @yield('content-js')
</body>
</html>