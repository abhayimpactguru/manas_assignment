<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('customers.export.csv') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Export CSV
                </a>
                <a href="{{ route('customers.export.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    Export PDF
                </a>
                <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Add Customer
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('customers.index') }}" method="GET" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search by name or email..." 
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($customers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($customer->profile_image)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($customer->profile_image) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-600 font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->phone ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->orders_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
