@extends('components.app')

@section('title', 'Dashboard')

@section('navbar')
    <x-navbar :username="$username" active="dashboard" />
@endsection

@section('content')
<h1 class="judul">Halo, {{ $username }}</h1>
<p class="lead">
    @if ($mendesak > 0)
        {{ $mendesak }} tugas jatuh tempo dalam 3 hari ke depan.
    @else
        Tidak ada tugas yang mendesak. Waktu yang baik untuk mencicil.
    @endif
</p>

<section class="stat-grid" aria-label="Ringkasan tugas">
    @foreach ($ringkasan as $item)
        @include('components.stat', ['angka' => $item['angka'], 'label' => $item['label'], 'tone' => $item['tone']])
    @endforeach
</section>

<section class="panel">
    <h2 class="panel__judul">Tenggat terdekat</h2>

    <ul class="daftar">
        @foreach ($terdekat as $t)
            <li class="daftar__item">
                <div>
                    <strong>{{ $t['judul'] }}</strong>
                    <span class="redup">{{ $t['matkul'] }}</span>
                </div>
                <span class="sisa {{ $t['sisa'] <= 3 ? 'sisa--dekat' : '' }}">{{ $t['sisa_teks'] }}</span>
            </li>
        @endforeach
    </ul>

    <a class="tautan" href="{{ route('pengelolaan', ['username' => $username]) }}">Lihat semua tugas</a>
</section>
@endsection
