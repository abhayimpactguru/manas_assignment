<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Customer Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            @if($customer->profile_image)
                                <img src="{{ Storage::url($customer->profile_image) }}" alt="{{ $customer->name }}" class="mx-auto h-32 w-32 rounded-full object-cover">
                            @else
                                <div class="mx-auto h-32 w-32 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-4xl text-indigo-600 font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ $customer->name }}</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900">{{ $customer->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Phone</label>
                                <p class="text-gray-900">{{ $customer->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Address</label>
                                <p class="text-gray-900">{{ $customer->address ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Member Since</label>
                                <p class="text-gray-900">{{ $customer->created_at->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Total Revenue</label>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($customer->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Orders -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Orders ({{ $customer->orders->count() }})</h3>
                            <a href="{{ route('orders.create') }}?customer_id={{ $customer->id }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Add Order
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($customer->orders as $order)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->amount, 2) }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->order_date->format('M d, Y') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
