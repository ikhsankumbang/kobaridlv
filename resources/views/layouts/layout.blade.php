<!doctype html>
<html lang="en">

<head>
    <title>@yield('title') | Kobarid</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url({{ asset('images/bengkel.png') }});"></a>
                <ul class="list-unstyled components mb-5">
                    <li class="{{ request()->is('home') ? 'active' : '' }}">
                        <a href="{{ url('/home') }}"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->is('customer*') ? 'active' : '' }}">
                        <a href="{{ url('/customer') }}"><i class="fas fa-users"></i> Customer</a>
                    </li>
                    <li class="{{ request()->is('barang*') ? 'active' : '' }}">
                        <a href="{{ url('/barang') }}"><i class="fas fa-boxes"></i> Barang</a>
                    </li>
                    <li class="{{ request()->is('pegawai*') ? 'active' : '' }}">
                        <a href="{{ url('/pegawai') }}"><i class="fas fa-user-tie"></i> Pegawai</a>
                    </li>
                    <li class="{{ request()->is('purchase-order*') ? 'active' : '' }}">
                        <a href="{{ url('/purchase-order') }}"><i class="fas fa-shopping-cart"></i> Purchase Order</a>
                    </li>
                    <li class="{{ request()->is('surat-jalan*') ? 'active' : '' }}">
                        <a href="{{ url('/surat-jalan') }}"><i class="fas fa-truck"></i> Surat Jalan</a>
                    </li>
                    <li class="{{ request()->is('invoice*') ? 'active' : '' }}">
                        <a href="{{ url('/invoice') }}"><i class="fas fa-file-invoice-dollar"></i> Invoice</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                <div class="footer">
                    <p>Kobarid &copy;<script>document.write(new Date().getFullYear());</script></p>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/home') }}">Home</a>
                            </li>
                            <li class="nav-item {{ request()->is('customer*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/customer') }}">Customer</a>
                            </li>
                            <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/barang') }}">Barang</a>
                            </li>
                            <li class="nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/pegawai') }}">Pegawai</a>
                            </li>
                            <li class="nav-item {{ request()->is('purchase-order*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/purchase-order') }}">Purchase Order</a>
                            </li>
                            <li class="nav-item {{ request()->is('surat-jalan*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/surat-jalan') }}">Surat Jalan</a>
                            </li>
                            <li class="nav-item {{ request()->is('invoice*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/invoice') }}">Invoice</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
