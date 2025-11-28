<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight" style="color: #430a1e;">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-4 pb-6 sm:pt-6 sm:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl" style="min-height: 600px; display: flex; align-items: flex-start;">
                <div class="p-6 sm:p-8 md:p-12 lg:p-16 text-gray-900 dark:text-gray-100 w-full pt-8 sm:pt-12">
                    <div class="text-center mb-16">
                        <h3 class="text-6xl sm:text-7xl font-bold mb-6" style="color: #430a1e;">Welcome, Admin!</h3>
                    </div>
                    
                    <div class="flex justify-center items-center gap-6 mb-16 flex-wrap">
                        <a href="{{ route('admin.products.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-3 rounded-full text-white font-semibold text-base transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105"
                           style="background: linear-gradient(135deg, #6c1835 0%, #49091f 100%); min-width: 200px;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                            <i class="fas fa-box mr-2 text-base"></i> Manage Products
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-3 rounded-full text-white font-semibold text-base transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105"
                           style="background: linear-gradient(135deg, #6c1835 0%, #49091f 100%); min-width: 200px;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                            <i class="fas fa-folder mr-2 text-base"></i> Manage Categories
                        </a>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-3 rounded-full text-white font-semibold text-base transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105"
                           style="background: linear-gradient(135deg, #6c1835 0%, #49091f 100%); min-width: 200px;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                            <i class="fas fa-shopping-cart mr-2 text-base"></i> Manage Orders
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-3 rounded-full text-white font-semibold text-base transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105"
                           style="background: linear-gradient(135deg, #6c1835 0%, #49091f 100%); min-width: 200px;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                            <i class="fas fa-envelope mr-2 text-base"></i> Contact Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
