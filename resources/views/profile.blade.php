@extends('layouts.app')

@section('title', 'Profil')

@section('navbar')
    <x-navbar :username="$username" active="profile" />
@endsection

@section('content')
<h1 class="judul">Profil</h1>
<p class="lead">Masuk sebagai <strong>{{ $username }}</strong>.</p>

<section class="panel profil">
    @if ($foto)
        <img class="avatar" src="{{ $foto }}" alt="Foto profil {{ $username }}">
    @else
        <div class="avatar avatar--huruf" aria-hidden="true">{{ mb_strtoupper(mb_substr($username, 0, 1)) }}</div>
    @endif

    <div>
        <h2 class="panel__judul">Biodata</h2>
        <dl class="biodata">
            @foreach ($biodata as $label => $nilai)
                <dt>{{ $label }}</dt>
                <dd>{{ $nilai }}</dd>
            @endforeach
        </dl>
    </div>
</section>
@endsection