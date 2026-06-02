<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Secure Online Voting System</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-black text-white">
            <!-- Navigation -->
            <nav class="border-b border-blue-900 bg-black">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center gap-3">
                            <x-application-logo class="h-8 w-8 text-green-400" />
                            <h1 class="text-2xl font-bold text-green-400">Voting System</h1>
                        </div>
                        <div class="flex gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                                    <x-icons.dashboard class="h-4 w-4 me-2" />
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-blue-200 hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-200 hover:text-white">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                                    Register
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <x-application-logo class="h-24 w-24 text-green-400" />
                    </div>
                    <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
                        Secure Online Voting System
                    </h2>
                    <p class="mx-auto mt-6 max-w-2xl text-lg text-blue-200">
                        Transparent, secure, and instant election results for Gasabo District. Your vote matters.
                    </p>

                    <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                        @auth
                            <a href="{{ route('vote.index') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-green-700">
                                <x-icons.vote class="h-5 w-5 me-2" />
                                Cast Your Vote
                            </a>
                            <a href="{{ route('results.index') }}" class="inline-flex items-center justify-center rounded-md border border-blue-700 bg-blue-950 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-blue-900">
                                <x-icons.chart class="h-5 w-5 me-2" />
                                View Results
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-green-700">
                                <x-icons.vote class="h-5 w-5 me-2" />
                                Get Started
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md border border-blue-700 bg-blue-950 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-blue-900">
                                <x-icons.shield class="h-5 w-5 me-2" />
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Features Section -->
                <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-3">
                    <div class="rounded-lg bg-blue-950 p-8 shadow-sm ring-1 ring-blue-900 border border-blue-700">
                        <h3 class="text-lg font-semibold text-green-400">Secure</h3>
                        <p class="mt-2 text-sm text-blue-200">
                            Your password is encrypted and votes are stored securely. Only authenticated voters can cast a vote.
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-950 p-8 shadow-sm ring-1 ring-blue-900 border border-blue-700">
                        <h3 class="text-lg font-semibold text-green-400">Transparent</h3>
                        <p class="mt-2 text-sm text-blue-200">
                            Real-time vote tallying and results ensure complete transparency in the election process.
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-950 p-8 shadow-sm ring-1 ring-blue-900 border border-blue-700">
                        <h3 class="text-lg font-semibold text-green-400">Fair</h3>
                        <p class="mt-2 text-sm text-blue-200">
                            One voter, one vote. The system enforces voting rules strictly to ensure fairness.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
