<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <!-- Customer -->
                        <div class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer *</label>
                            <select name="customer_id" id="customer_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}" 
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required>
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" id="status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Date -->
                        <div class="mb-4">
                            <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date *</label>
                            <input type="date" name="order_date" id="order_date" value="{{ old('order_date', date('Y-m-d')) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                            @error('order_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
