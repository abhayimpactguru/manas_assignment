<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('orders.edit', $order) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Order Header -->
                    <div class="border-b pb-6 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h3>
                                <p class="text-gray-500 mt-1">Created on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
                            </div>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Order Number</label>
                                    <p class="text-gray-900">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Amount</label>
                                    <p class="text-2xl font-bold text-green-600">${{ number_format($order->amount, 2) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Order Date</label>
                                    <p class="text-gray-900">{{ $order->order_date->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status</label>
                                    <p class="text-gray-900">{{ ucfirst($order->status) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h4>
                            <div class="flex items-center mb-4">
                                @if($order->customer->profile_image)
                                    <img src="{{ Storage::url($order->customer->profile_image) }}" alt="{{ $order->customer->name }}" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-2xl text-indigo-600 font-medium">{{ substr($order->customer->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <a href="{{ route('customers.show', $order->customer) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-800">
                                        {{ $order->customer->name }}
                                    </a>
                                    <p class="text-gray-500">{{ $order->customer->email }}</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Phone</label>
                                    <p class="text-gray-900">{{ $order->customer->phone ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Address</label>
                                    <p class="text-gray-900">{{ $order->customer->address ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
