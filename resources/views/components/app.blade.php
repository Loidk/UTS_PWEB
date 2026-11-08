<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>@yield('title', 'Folio') - Folio</title>
</head>
<body>
    @yield('navbar')

    <main class="page">
        @yield('content')
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>
