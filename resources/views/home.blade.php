<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Google Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="antialiased">
    <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full lg:w-2/6 mx-auto p-6 lg:p-8 ">
            <div
                class="scale-100 px-10 py-20 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 justify-center text-center">
                <div class="d-block text-center">
                    @auth
                        <h1 class="text-3xl font-bold mb-10">{{ __('Welcome') }}, <span class="font-semibold">{{ Auth::user()->name }}</span></h1>
                        <a class="d-inline-block py-3 px-20 bg-black text-white font-semibold text-lg rounded-full shadow-md  focus:outline-none focus:ring-2 focus:ring-opacity-75" href="{{ route('logout') }}">
                            {{ __('Logout') }}
                        </a>
                    @else
                        <h1 class="text-3xl font-semibold mb-10">{{ __('Login With Google') }}</h1>
                        <a class="d-block" href="{{ route('loginWithGoogle') }}">
                            <img class="m-auto"
                                src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>

</html>
