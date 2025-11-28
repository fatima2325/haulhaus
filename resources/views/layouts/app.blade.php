<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Haul Haus Bags')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>

{{-- ================= HEADER ================= --}}
<header class="top-section">
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Haul Haus Logo">
            <h2>Haul Haus Bags</h2>
        </div>

        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('shop') }}">Shop</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ route('cart.view') }}"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
        </ul>
    </nav>
</header>

{{-- ================= MAIN CONTENT ================= --}}
<main>
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="footer">
    <div class="footer-content">
        <p>&copy; {{ date('Y') }} Haul Haus Bags. All rights reserved.</p>
        <div class="socials">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
        </div>
    </div>
</footer>

</body>
</html>
