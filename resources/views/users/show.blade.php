<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-4xl text-indigo-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Member Since</label>
                            <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="text-gray-900">{{ $user->updated_at->format('F d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center space-x-3">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
