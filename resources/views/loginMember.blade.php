<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: rgba(0, 123, 255, 0.9);
            color: white;
            padding: 15px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .header img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }
        .header h1 {
            display: inline-block;
            font-size: 1.8rem;
            font-weight: bold;
            vertical-align: middle;
            margin: 0;
        }

        body {
            background: url('{{ asset("images/image.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .content {
            padding-top: 100px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
        }
        .card h3 {
            color: #333;
        }
        .form-group label {
            color: #555;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center justify-content-center vh-100">

    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Library System Logo">
        <h1>Library System</h1>
    </div>

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login as Member</h3>

                        @if ($errors->has('loginError'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('loginError') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('member.loginMember') }}">
                            @csrf
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter your Contact Number" required autocomplete="off"/>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="off"/>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
