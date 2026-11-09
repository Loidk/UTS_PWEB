@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<section class="cover">
    <h1 class="cover__judul">Folio</h1>
    <p class="cover__sub">Pencatatan Tugas.</p>

    <form class="cover__form" method="POST" action="{{ route('login.proses') }}" novalidate>
        @csrf
        <label for="username">Nama pengguna</label>
        <input id="username" name="username" type="text" value="{{ old('username') }}"
               autocomplete="username" autofocus aria-describedby="username-error">

        @error('username')
            <p class="galat" id="username-error" role="alert">{{ $message }}</p>
        @enderror

        <button type="submit" class="tombol">Masuk</button>
    </form>
</section>
@endsection
