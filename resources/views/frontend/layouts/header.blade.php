<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Haul Haus Bags</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<style>
    /* Make navbar sticky with smooth show/hide */
    header.top-section {
        position: sticky;
        top: 0;
        z-index: 1030;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        background: #430a1e;
    }
    .nav-search {
        min-width: 240px;
    }
    @media (min-width: 992px) {
        .nav-search {
            max-width: 360px;
        }
    }
    .nav-search .form-control {
        border: 1px solid rgba(255,255,255,0.35);
        background: rgba(255,255,255,0.12);
        color: #fff;
        padding-left: 42px;
    }
    .nav-search .form-control::placeholder {
        color: rgba(255,255,255,0.75);
    }
    .nav-search .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.85);
    }
    .nav-search-results {
        display: none;
        z-index: 1050;
        max-height: 320px;
        overflow-y: auto;
    }
    header.top-section.nav-hidden {
        transform: translateY(-100%);
        box-shadow: none;
    }
    header.top-section.nav-visible {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }
</style>

<body>

<header class="top-section py-2 ">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/images/logo9.png') }}" width="125" alt="HaulHaus Bags Logo">

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center w-100 gap-3">
                    <form class="nav-search position-relative w-100 order-1 order-lg-1" role="search" onsubmit="return false;">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search"
                               id="nav-search-input"
                               class="form-control rounded-pill"
                               placeholder="Search by name or category"
                               autocomplete="off">
                        <div id="nav-search-results" class="nav-search-results bg-white border rounded shadow position-absolute w-100 mt-2">
                            <ul class="list-group list-group-flush" id="nav-search-results-list"></ul>
                        </div>
                    </form>

                    <ul class="navbar-nav ms-lg-auto align-items-center order-2 order-lg-2">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Shop
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                            <li><a class="dropdown-item" href="{{ url('shop') }}">All Products</a></li>
                            @php
                                $categories = \App\Models\Category::orderBy('name')->get();
                            @endphp
                            @foreach($categories as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ url('shop') }}#{{ strtolower(str_replace(' ', '-', $category->name)) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Contact</a></li>

                    @auth
                        @if(auth()->user()->name === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-cog"></i> Admin Panel
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-shield"></i> Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ url('cart') }}">
                                    <i class="fas fa-shopping-cart cart-icon"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-shopping-bag mr-2"></i> My Orders</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.view') }}">
                                <i class="fas fa-shopping-cart cart-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Show navbar when scrolling up; hide when scrolling down
        const header = document.querySelector('header.top-section');
        if (header) {
            let lastScroll = window.pageYOffset || 0;
            header.classList.add('nav-visible');

            window.addEventListener('scroll', () => {
                const current = window.pageYOffset || 0;
                const scrollingUp = current < lastScroll;
                const nearTop = current < 60;

                if (scrollingUp || nearTop) {
                    header.classList.remove('nav-hidden');
                    header.classList.add('nav-visible');
                } else {
                    header.classList.remove('nav-visible');
                    header.classList.add('nav-hidden');
                }

                lastScroll = current;
            }, { passive: true });
        }

        // Global product search (available on every page)
        const input = document.getElementById('nav-search-input');
        const box = document.getElementById('nav-search-results');
        const list = document.getElementById('nav-search-results-list');
        const searchUrl = "{{ route('shop.search') }}";
        let timer;

        const hide = () => {
            if (!box || !list) return;
            box.style.display = 'none';
            list.innerHTML = '';
        };

        const render = (items) => {
            if (!box || !list) return;
            list.innerHTML = '';

            if (!items.length) {
                list.innerHTML = '<li class="list-group-item text-muted">No matches found</li>';
                box.style.display = 'block';
                return;
            }

            items.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex align-items-center gap-3';
                li.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="rounded border" style="width:48px; height:48px; object-fit:cover;">
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="color:#430a1e;">${item.name}</div>
                        <div class="text-muted small">${item.category} · Rs. ${Number(item.price).toLocaleString()}</div>
                    </div>
                    <span class="text-primary small">View</span>
                `;
                li.addEventListener('click', () => {
                    window.location.href = item.url;
                });
                list.appendChild(li);
            });

            box.style.display = 'block';
        };

        input?.addEventListener('input', () => {
            const q = input.value.trim();
            clearTimeout(timer);

            if (!q) {
                hide();
                return;
            }

            timer = setTimeout(() => {
                fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(data => render(data.data || []))
                    .catch(() => hide());
            }, 250);
        });

        document.addEventListener('click', (e) => {
            if (!box || !input) return;
            if (!box.contains(e.target) && e.target !== input) {
                hide();
            }
        });
    });
</script>
</body>
</html>
