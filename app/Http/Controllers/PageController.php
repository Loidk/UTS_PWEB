<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // LOGIN

    public function login()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:30',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min'      => 'Username minimal 3 karakter.',
            'username.max'      => 'Username maksimal 30 karakter.',
        ]);

        return redirect()->route('dashboard', [
            'username' => $request->input('username'),
        ]);
    }

    // DASHBOARD

    public function dashboard(Request $request)
    {
        $username = trim((string) $request->query('username', ''));
        if ($username === '') {
            return redirect()->route('login');
        }

        $tugas = collect($this->daftarTugas($username));

        $aktif    = $tugas->where('status', '!=', 'Selesai');
        $mendesak = $aktif->filter(fn ($t) => $t['sisa'] <= 3)->count();

        $ringkasan = [
            ['angka' => $tugas->count(),                                'label' => 'Total tugas',         'tone' => ''],
            ['angka' => $tugas->where('status', 'Selesai')->count(),    'label' => 'Selesai',             'tone' => 'ok'],
            ['angka' => $tugas->where('status', 'Dikerjakan')->count(), 'label' => 'Sedang dikerjakan',   'tone' => ''],
            ['angka' => $mendesak,                                      'label' => 'Tenggat 3 hari lagi', 'tone' => 'warn'],
        ];

        $terdekat = $aktif->sortBy('sisa')->take(4)->values()->all();

        return view('dashboard', compact('username', 'ringkasan', 'terdekat', 'mendesak'));
    }

    // PENGELOLAAN

    public function pengelolaan(Request $request)
    {
        $username = trim((string) $request->query('username', ''));
        if ($username === '') {
            return redirect()->route('login');
        }

        $tugas = collect($this->daftarTugas($username))->sortBy('sisa')->values()->all();

        return view('pengelolaan', compact('username', 'tugas'));
    }

    // PROFILE

    public function profile(Request $request)
    {
        $username = trim((string) $request->query('username', ''));
        if ($username === '') {
            return redirect()->route('login');
        }

        $pengguna = $this->pengguna($username);
        $biodata  = $pengguna['biodata'];

        $foto = ($pengguna['foto'] && file_exists(public_path($pengguna['foto'])))
            ? asset($pengguna['foto'])
            : null;

        return view('profile', compact('username', 'biodata', 'foto'));
    }

    // DATA

    private function pengguna(string $username): array
    {
        $semua = $this->dataPengguna();

        return $semua[mb_strtolower($username)] ?? $semua['_default'];
    }

    private function dataPengguna(): array
    {
        return [

            'andro' => [
                'foto'    => 'images/1.jpg',
                'biodata' => [
                    'Nama lengkap'  => 'Andro Mahesha Aprian',
                    'NIM'           => '000000001',
                    'Program studi' => 'Informatika',
                    'Kampus'        => 'Universitas Jember',
                    'Semester'      => '3',
                ],
                'tugas' => [
                    ['matkul' => 'Pemrograman Web',        'judul' => 'UTS Laravel',     'hari' => 2,  'prioritas' => 'Tinggi', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Arsitektur Komputer',    'judul' => 'Evaluasi 3',      'hari' => 1,  'prioritas' => 'Tinggi', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Grafika Komputer',       'judul' => 'Final Project',   'hari' => 5,  'prioritas' => 'Sedang', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Pemrograman Fungsional', 'judul' => 'Final project',   'hari' => 9,  'prioritas' => 'Sedang', 'status' => 'Belum'],

                ],
            ],

            'germok' => [
                'foto'    => 'images/2.jpg',
                'biodata' => [
                    'Nama lengkap'  => 'Gerald Karbit',
                    'NIM'           => '000000000000',
                    'Program studi' => 'Sistem Teknologi informatika',
                    'Kampus'        => 'Universitas Jember',
                    'Semester'      => '0',
                ],
                'tugas' => [
                    ['matkul' => 'Basis Data',     'judul' => 'ERD toko online',  'hari' => 3,  'prioritas' => 'Tinggi', 'status' => 'Belum'],
                    ['matkul' => 'Matematika',     'judul' => 'Soal integral',    'hari' => 6,  'prioritas' => 'Rendah', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Bahasa Inggris', 'judul' => 'Esai 300 kata',    'hari' => -1, 'prioritas' => 'Sedang', 'status' => 'Selesai'],
                ],
            ],

            // default
            '_default' => [
                'foto'    => 'images/profil.jpg',
                'biodata' => [
                    'Nama lengkap'  => 'TungTung',
                    'NIM'           => '123456789',
                    'Program studi' => 'Informatika',
                    'Kampus'        => 'Universitas Jember',
                    'Semester'      => '100',
                ],
                'tugas' => [
                    ['matkul' => 'Pemrograman Web',                     'judul' => 'UTS', 'hari' => 2,  'prioritas' => 'Tinggi', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Arsitektur Komputer',                 'judul' => 'UTS', 'hari' => 1,  'prioritas' => 'Tinggi', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Grafika Komputer',                    'judul' => 'UTS', 'hari' => 5,  'prioritas' => 'Sedang', 'status' => 'Dikerjakan'],
                    ['matkul' => 'Pemrograman Fungsional',              'judul' => 'UTS', 'hari' => 9,  'prioritas' => 'Sedang', 'status' => 'Belum'],
                    ['matkul' => 'Pemrograman Berorientasi Objek',      'judul' => 'UTS', 'hari' => 6,  'prioritas' => 'Sedang', 'status' => 'Belum'],
                    ['matkul' => 'Analisis dan Desain Perangkat Lunak', 'judul' => 'UTS', 'hari' => 12, 'prioritas' => 'Rendah', 'status' => 'Belum'],
                    ['matkul' => 'Pertanian Industrial Berkelanjutan',  'judul' => 'UTS', 'hari' => 14, 'prioritas' => 'Rendah', 'status' => 'Belum'],
                ],
            ],
        ];
    }

    private function daftarTugas(string $username): array
    {
        $hariIni = Carbon::today();
        $data    = $this->pengguna($username)['tugas'];

        return array_map(function ($t) use ($hariIni) {
            $tenggat = $hariIni->copy()->addDays($t['hari']);
            $sisa    = (int) $hariIni->diffInDays($tenggat, false);

            $t['sisa']         = $sisa;
            $t['tenggat_teks'] = $tenggat->format('d/m/Y');

            if ($t['status'] === 'Selesai') {
                $t['sisa_teks'] = 'Selesai';
            } elseif ($sisa < 0) {
                $t['sisa_teks'] = 'Terlewat ' . abs($sisa) . ' hari';
            } elseif ($sisa === 0) {
                $t['sisa_teks'] = 'Hari ini';
            } else {
                $t['sisa_teks'] = $sisa . ' hari lagi';
            }

            return $t;
        }, $data);
    }
}