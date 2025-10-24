<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.app_name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('users.index') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
                    <div class="w-8 h-8 bg-gray-800 rounded flex items-center justify-center">
                        <span class="text-white text-sm font-bold">W</span>
                    </div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-900">{{ __('app.app_name') }}</h1>
                </a>
                <div class="flex items-center space-x-2 md:space-x-6">
                    <a href="{{ route('users.index') }}"
                       class="px-3 py-2 md:px-4 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <i class="fas fa-users mr-1 md:mr-2"></i>
                        <span class="hidden sm:inline">{{ __('navigation.users') }}</span>
                    </a>
                    <a href="{{ route('email.test.form') }}"
                       class="px-3 py-2 md:px-4 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('email.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <i class="fas fa-envelope mr-1 md:mr-2"></i>
                        <span class="hidden sm:inline">{{ __('navigation.test_emails') }}</span>
                    </a>

                    <!-- Language Switcher -->
                    <div class="relative">
                        <form method="POST" action="{{ route('language.switch') }}" class="inline">
                            @csrf
                            <select name="locale" onchange="this.form.submit()"
                                    class="appearance-none bg-white border border-gray-300 rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 cursor-pointer">
                                <option value="da" {{ app()->getLocale() === 'da' ? 'selected' : '' }}>
                                    Dansk
                                </option>
                                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                                    English
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                    <span class="text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
