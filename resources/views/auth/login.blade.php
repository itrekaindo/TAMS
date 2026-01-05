@extends('layouts.app-landing')
@section('title', 'Login — ' . config('app.name'))

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-md">
        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="text-center mb-8">
                <img
                    src="{{ asset('img/logo-black.png') }}"
                    alt="Logo Sistem Peminjaman Alat"
                    class="mx-auto h-16 w-auto"
                >

            </div>
            <h1 class="text-2xl font-bold text-gray-800">Tools Assets Management System</h1>
            <p class="text-gray-600 mt-2">Masuk ke akun admin Anda</p>
        </div>

        <!-- Session Status (Success/Error) -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-center text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        <i class="bi bi-envelope-fill text-gray-500 mr-1.5"></i> Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="email-anda@mail.com"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            <i class="bi bi-lock-fill text-gray-500 mr-1.5"></i> Password
                        </label>

                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="••••••••"
                    >

                        {{-- @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                Lupa password?
                            </a>
                        @endif --}}

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <label for="remember_me" class="ms-2 text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            <!-- Back to Public Portal -->
            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-800">
                    <i class="bi bi-arrow-left"></i> Kembali ke halaman publik
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
