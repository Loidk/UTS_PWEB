# UTS Pemrograman Web (PWEB)

Aplikasi web berbasis **Laravel** yang dibuat untuk memenuhi tugas **Ujian Tengah Semester (UTS) Pemrograman Web**.

## Deskripsi

Folio, yaitu aplikasi pencatat tugas kuliah. Website ini dibangun menggunakan Laravel murni dengan pola MVC dan templating Blade. Saya tidak memakai starter kit dan tidak memakai database. Semua data disimpan dalam bentuk array di controller. Untuk tampilannya saya menulis CSS sendiri, dan ada sedikit JavaScript untuk fitur filter.
Tema pengelolaan yang saya pilih adalah pengelolaan tugas kuliah. Di dalamnya ada daftar tugas lengkap dengan mata kuliah, tenggat, prioritas, dan status pengerjaan. Alur penggunaannya dimulai dari login, lalu dashboard, profil, dan terakhir halaman pengelolaan

## Fitur

-  **Login** – autentikasi pengguna sebelum masuk ke sistem
-  **Dashboard** – ringkasan informasi dalam bentuk kartu
-  **Data Pengelola** – menampilkan dan mengelola data dalam bentuk tabel
-  **Profil** – menampilkan informasi akun pengguna
-  **Logout** – keluar dari sistem

## Tampilan Aplikasi

### Halaman Login

![Halaman Login](ss/login.jpg)

### Halaman Dashboard

![Halaman Dashboard](ss/dashboard.jpg)

### Halaman Pengelola

![Halaman Pengelola](ss/pengelola.jpg)

### Halaman Profil

![Halaman Profil](ss/profil.jpg)

## Teknologi yang Digunakan

- **Framework:** Laravel (PHP 8.2+)
- **Frontend:** Blade Template, CSS, JavaScript


## Cara Menjalankan

### Prasyarat
- PHP 8.2 atau lebih baru
- Composer
- Node.js & npm
- MySQL (sudah termasuk di Laragon)

### Langkah Instalasi

1. **Clone repository** ke folder `www` Laragon:
   ```bash
   cd C:\laragon\www
   git clone https://github.com/Loidk/UTS_PWEB_252410103057.git UTS_PWEB
   cd UTS_PWEB
   ```


2. **Jalankan aplikasi:**
   ```bash
   npm run dev
   php artisan serve
   ```
   Buka di browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)






