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

        $tugas = collect($this->daftarTugas());

        $aktif    = $tugas->where('status', '!=', 'Selesai');
        $mendesak = $aktif->filter(fn ($t) => $t['sisa'] <= 3)->count();

        $ringkasan = [
            ['angka' => $tugas->count(),                                    'label' => 'Total tugas',        'tone' => ''],
            ['angka' => $tugas->where('status', 'Selesai')->count(),        'label' => 'Selesai',            'tone' => 'ok'],
            ['angka' => $tugas->where('status', 'Dikerjakan')->count(),     'label' => 'Sedang dikerjakan',  'tone' => ''],
            ['angka' => $mendesak,                                          'label' => 'Tenggat 3 hari lagi', 'tone' => 'warn'],
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

        $tugas = collect($this->daftarTugas())->sortBy('sisa')->values()->all();

        return view('pengelolaan', compact('username', 'tugas'));
    }

    // PROFILE
    public function profile(Request $request)
    {
        $username = trim((string) $request->query('username', ''));
        if ($username === '') {
            return redirect()->route('login');
        }

        
        $biodata = [
            'Nama lengkap' => 'TungTung',
            'NIM'          => '123456789',
            'Program studi' => 'Informatika',
            'Kampus'       => 'Universitas Jember',
            'Semester'     => '0',
        ];

        $kebiasaan = [
            'Kerjakan tugas berbobot besar lebih dulu',
            'Tulis tenggat di Folio, bukan di kepala',
            'Sisakan sehari sebelum tenggat untuk memeriksa ulang',
        ];

        return view('profile', compact('username', 'biodata', 'kebiasaan'));
    }

    // DATA

    private function daftarTugas(): array
    {
        $hariIni = Carbon::today();

        $data = [
            ['matkul' => 'Pemrograman Web',        'judul' => 'UTS','tenggat' => $hariIni->copy()->addDays(2),  'prioritas' => 'Tinggi',  'status' => 'Dikerjakan'],
            ['matkul' => 'Arsitektur Komputer',    'judul' => 'UTS','tenggat' => $hariIni->copy()->addDays(1),  'prioritas' => 'Tinggi',  'status' => 'Dikerjakan'],
            ['matkul' => 'Grafika Komputer',       'judul' => 'UTS','tenggat' => $hariIni->copy()->addDays(5),  'prioritas' => 'Sedang',  'status' => 'Dikerjakan'],
            ['matkul' => 'Pemrograman Fungsional', 'judul' => 'UTS','tenggat' => $hariIni->copy()->addDays(9),  'prioritas' => 'Sedang',  'status' => 'Belum'],
            ['matkul' => 'Pemrograman Berorientasi Objek', 'judul' => 'UTS', 'tenggat' => $hariIni->copy()->addDays(6),  'prioritas' => 'Sedang',  'status' => 'Belum'],
            ['matkul' => 'Analisis dan Desain Perangkat Lunak', 'judul' => 'UTS', 'tenggat' => $hariIni->copy()->addDays(12), 'prioritas' => 'Rendah',  'status' => 'Belum'],
            ['matkul' => 'Pertanian Industrial Berkelanjutan', 'judul' => 'UTS', 'tenggat' => $hariIni->copy()->addDays(14), 'prioritas' => 'Rendah', 'status' => 'Belum'],
        ];

        return array_map(function ($t) use ($hariIni) {
            $sisa = (int) $hariIni->diffInDays($t['tenggat'], false);

            $t['sisa']         = $sisa;
            $t['tenggat_teks'] = $t['tenggat']->format('d/m/Y');

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
