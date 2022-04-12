<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Q:Maker Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

        <!-- Styles -->

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased ">
        <div class="relative flex items-top justify-center min-h-screen azur-lane-gradient-animated dark:bg-gray-900 items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-lg text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-lg text-white">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-lg text-white">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="text-center">
                <p class="text-white font-bold" style="font-size: 5rem">Q:Maker</p>
                <p class="text-white text-2xl">RTU Queue System</p>
            </div>
            

        </div>
    </body>
</html>
