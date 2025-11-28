@extends('admin.layout')

@section('title', 'Contact Message Details')
@section('header', 'Contact Message Details')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-3xl font-bold mb-2" style="color: #430a1e;">Message Details</h3>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                style="background: #6c1835; color: white; min-width: 120px; height: 32px;"
                                onmouseover="this.style.background='#49091f'"
                                onmouseout="this.style.background='#6c1835'"
                                onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Name</label>
                <p class="text-lg font-semibold" style="color: #430a1e;">{{ $contact->name }}</p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Email</label>
                <p class="text-gray-900 dark:text-gray-100">
                    <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">{{ $contact->email }}</a>
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Date Received</label>
                <p class="text-gray-900 dark:text-gray-100">
                    {{ $contact->created_at->format('F d, Y h:i A') }}
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Message</label>
                <div class="bg-white dark:bg-gray-600 p-4 rounded-lg border border-gray-200 dark:border-gray-500">
                    <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.contacts.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
               style="background: #6c1835; color: white; min-width: 140px; height: 38px;"
               onmouseover="this.style.background='#49091f'"
               onmouseout="this.style.background='#6c1835'">
                <i class="fas fa-arrow-left mr-2"></i> Back to Messages
            </a>
        </div>
    </div>
</div>
@endsection

