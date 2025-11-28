@extends('admin.layout')

@section('title', 'Contact Messages')
@section('header', 'Contact Messages')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2" style="color: #430a1e;">Contact Messages</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage all contact form submissions</p>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full shadow-md rounded-lg overflow-hidden" style="border-collapse: separate; border-spacing: 0 12px;">
                <thead>
                    <tr style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Message Preview</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Date</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition-colors duration-150" style="background: white; margin-bottom: 12px; border-bottom: 2px solid #e5e7eb;">
                            <td class="px-6 py-6 whitespace-nowrap text-sm font-semibold text-gray-700">{{ $contact->id }}</td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold" style="color: #430a1e;">{{ $contact->name }}</div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $contact->email }}</div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="text-sm text-gray-600 max-w-xs truncate">
                                    {{ \Illuminate\Support\Str::limit($contact->message, 80) }}
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm text-gray-600">
                                    {{ $contact->created_at->format('M d, Y') }}<br>
                                    <span class="text-xs text-gray-500">{{ $contact->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                       style="background: #6c1835; color: white; min-width: 80px; height: 32px;"
                                       onmouseover="this.style.background='#49091f'"
                                       onmouseout="this.style.background='#6c1835'"
                                       title="View Message">
                                        <i class="fas fa-eye mr-1.5"></i> View
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                                style="background: #6c1835; color: white; min-width: 80px; height: 32px;"
                                                onmouseover="this.style.background='#49091f'"
                                                onmouseout="this.style.background='#6c1835'"
                                                onclick="return confirm('Are you sure you want to delete this message?')" 
                                                title="Delete Message">
                                            <i class="fas fa-trash mr-1.5"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl mb-3" style="color: #d1d5db;"></i>
                                    <p class="text-sm font-medium text-gray-500">No contact messages found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

