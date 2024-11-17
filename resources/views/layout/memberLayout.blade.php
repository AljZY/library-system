<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Panel')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Custom blue theme */
        .navbar-custom {
            background-color: #007bff;
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }
        .sidebar {
            background-color: #0056b3;
            height: 100vh;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #004085;
        }
        .btn-logout {
            background-color: #004085;
            border-color: #004085;
        }
        .btn-logout:hover {
            background-color: #003366;
            border-color: #003366;
        }
        .brand-text {
            font-family: Arial, sans-serif;
            font-size: 2rem;
            color: white;
        }
        .content-area {
            height: 100vh;
            overflow-y: auto;
        }
    </style>

</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand brand-text" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Library System Logo" width="50" height="50" class="d-inline-block align-top">
                Library System
            </a>
            <div class="ml-auto">
            <a href="{{ route('member.logout') }}" class="btn btn-logout text-white">
                <i class="bi bi-power"></i>
            </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid d-flex min-vh-100">
        <div class="row flex-fill">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 sidebar d-flex flex-column">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.homepage') ? 'active' : '' }}" href="{{ route('member.homepage') }}">
                                <i class="bi bi-house-door-fill mr-2"></i>
                                Homepage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.books') ? 'active' : '' }}" href="{{ route('member.books') }}">
                                <i class="bi bi-book-fill mr-2"></i>
                                Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.borrow-history') ? 'active' : '' }}" href="{{ route('member.borrow-history') }}">
                                <i class="bi bi-arrow-return-right mr-2"></i>
                                Borrow History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('member.changePassword') ? 'active' : '' }}" href="{{ route('member.changePassword') }}">
                                <i class="bi bi-key-fill mr-2"></i>
                                Change Password
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 col-lg-10 px-md-4 content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
