<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FitarSelf') - FitarSelf</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|montserrat:700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(180deg, #000000 0%, #702670 100%); min-height: 100vh; color: white;">

    <header style="text-align: center; padding: 20px 0;">
        <a href="/" style="font-size: 24px; font-weight: 900; color: white; text-decoration: none;">🏎️ Fitar<span style="color: #F47920;">Self</span></a>
    </header>

    <main style="max-width: 500px; margin: 0 auto; padding: 0 20px 100px;">
        @yield('content')
    </main>

    <footer style="text-align: center; color: #666; font-size: 13px; position: fixed; bottom: 10px; left: 0; right: 0;">
        © 2026 FitarSelf. All rights reserved.
    </footer>

</body>
</html>