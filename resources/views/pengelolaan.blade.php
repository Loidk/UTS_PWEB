@extends('layouts.app')

@section('title', 'Pengelolaan Tugas')

@section('navbar')
    <x-navbar :username="$username" active="pengelolaan" />
@endsection

@section('content')
<h1 class="judul">Pengelolaan tugas</h1>
<p class="lead">{{ count($tugas) }} tugas tercatat.</p>

<div class="filter" role="group" aria-label="Filter status">
    <button type="button" class="chip" data-filter="semua" aria-pressed="true">Semua</button>
    <button type="button" class="chip" data-filter="Belum" aria-pressed="false">Belum</button>
    <button type="button" class="chip" data-filter="Dikerjakan" aria-pressed="false">Dikerjakan</button>
    <button type="button" class="chip" data-filter="Selesai" aria-pressed="false">Selesai</button>
</div>

<div class="panel panel--tabel">
    <table class="tabel">
        <thead>
            <tr>
                <th scope="col">Mata kuliah</th>
                <th scope="col">Tugas</th>
                <th scope="col">Tenggat</th>
                <th scope="col">Prioritas</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tugas as $t)
                <tr data-status="{{ $t['status'] }}">
                    <td data-label="Mata kuliah">{{ $t['matkul'] }}</td>
                    <td data-label="Tugas"><strong>{{ $t['judul'] }}</strong></td>
                    <td data-label="Tenggat">
                        <span>
                            {{ $t['tenggat_teks'] }}
                            <span class="redup {{ $t['status'] !== 'Selesai' && $t['sisa'] <= 3 ? 'sisa--dekat' : '' }}">{{ $t['sisa_teks'] }}</span>
                        </span>
                    </td>
                    <td data-label="Prioritas"><span class="prio prio--{{ strtolower($t['prioritas']) }}">{{ $t['prioritas'] }}</span></td>
                    <td data-label="Status"><span class="status status--{{ strtolower($t['status']) }}">{{ $t['status'] }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/filter.js') }}"></script>
@endpush
