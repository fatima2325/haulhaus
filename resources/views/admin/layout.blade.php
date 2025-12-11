<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight" style="color: #430a1e;">
                @yield('header', 'Admin Panel')
            </h2>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-box mr-1.5"></i> Products
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-folder mr-1.5"></i> Categories
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-shopping-cart mr-1.5"></i> Orders
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-envelope mr-1.5"></i> Messages
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-home mr-1.5"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-sign-in-alt mr-1.5"></i> Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 100px; height: 32px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-user-plus mr-1.5"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm auto-dismiss-success" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Auto-dismiss success flashes after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.auto-dismiss-success').forEach(el => {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 5000);
    </script>
</x-app-layout>

