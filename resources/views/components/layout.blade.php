<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ngCloud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold me-4"
            href="/"
            style="font-family: 'Orbitron', sans-serif; font-size: 1.8rem;">
                ngCloud
            </a>
            
            <div class="d-flex align-items-center gap-3">

                <a href="/files"
                class="text-decoration-none text-dark fw-semibold">
                    Files
                </a>

            </div>

            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                    <span class="text-dark fw-semibold">
                        {{ ucfirst(auth()->user()->username) }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <div class="container py-4">
        {{ $slot }}
    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>