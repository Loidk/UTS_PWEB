@props(['username', 'active' => ''])

<header class="nav">
    <a class="nav__brand" href="{{ route('dashboard', ['username' => $username]) }}">Folio</a>

    <nav class="nav__links" aria-label="Menu utama">
        @foreach (['dashboard' => 'Dashboard', 'pengelolaan' => 'Pengelolaan', 'profile' => 'Profil'] as $rute => $teks)
            <a href="{{ route($rute, ['username' => $username]) }}"
               @class(['is-active' => $active === $rute])
               @if ($active === $rute) aria-current="page" @endif>{{ $teks }}</a>
        @endforeach
    </nav>

    <a class="nav__out" href="{{ route('login') }}">Keluar</a>
</header>
