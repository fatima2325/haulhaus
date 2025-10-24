<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trendura Bags</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

<header class="top-section py-2 ">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/images/logo2.png') }}" width="125" alt="Trendura Bags Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Shop
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                            <li><a class="dropdown-item" href="{{ url('shop') }}">All Products</a></li>

                            <li><a class="dropdown-item" href="{{ url('shop') }}#tote-bags">Tote Bags</a></li>
                            <li><a class="dropdown-item" href="{{ url('shop') }}#hobo-bags">Hobo Bags</a></li>
                            <li><a class="dropdown-item" href="{{ url('shop') }}#backpacks">Backpacks</a></li>
                            <li><a class="dropdown-item" href="{{ url('shop') }}#cross-body-bags">Crossbody Bags</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Contact</a></li>

                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ url('cart') }}">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
