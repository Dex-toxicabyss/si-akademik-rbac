# SI-Akademik RBAC

Portal informasi akademik berbasis **Laravel 11** dengan arsitektur **Role-Based Access Control (RBAC)** untuk tiga peran pengguna (**Admin**, **Dosen**, dan **Mahasiswa**) menggunakan custom middleware `CheckRole`.

## Gambaran Umum

**SI-Akademik RBAC** memisahkan hak akses operasional akademik secara terpusat pada level route dan HTTP verb. Setiap permintaan menuju modul manajemen pengguna (`/users`), distribusi materi perkuliahan (`/materi`), dan pengelolaan nilai akademik (`/nilai` serta `/nilai/manage`) divalidasi secara ketat oleh `CheckRole` middleware sebelum mencapai layer controller.

## Fitur Utama

- **Multi-Role Authentication & Session Security**: Autentikasi sesi terintegrasi (`POST /login` & `POST /logout`) dengan regenerasi session ID dan CSRF token serta atribut `role` (`admin`, `dosen`, `mahasiswa`) pada tabel `users`.
- **Variadic `CheckRole` Middleware**: Custom middleware `App\Http\Middleware\CheckRole` yang mendukung parameter multi-role (`role:admin`, `role:admin,dosen`, `role:admin,dosen,mahasiswa`) melalui registrasi alias di `bootstrap/app.php`.
- **Granular Route Protection**:
  - **Manajemen Pengguna (`/users`)**: Akses eksklusif untuk **Admin**.
  - **Materi Perkuliahan (`/materi`)**: Akses baca untuk seluruh sivitas akademika; hak publikasi dan penghapusan dibatasi untuk **Admin** dan **Dosen**.
  - **Nilai Akademik (`/nilai` & `/nilai/manage`)**: Transkrip nilai terfilter otomatis per mahasiswa pada `/nilai`, sedangkan input dan pembaruan nilai pada `/nilai/manage` dikunci khusus **Admin** dan **Dosen**.
- **Automated Feature Test Suite**: Pengujian otomatis menggunakan PHPUnit (`tests/Feature/RbacAccessTest.php`) untuk memverifikasi skenario otorisasi berhasil (`200 OK`) dan penolakan akses (`403 Forbidden` / `302 Redirect`).

## Tech Stack

- **Backend:** Laravel 11.x (PHP 8.2+)
- **Database:** MySQL / MariaDB
- **Frontend UI:** Blade Templates, Tailwind CSS, Linear Dark Design System (`Inter Tight`, `Inter`, `JetBrains Mono`)
- **Automated Testing:** PHPUnit 11 (`RefreshDatabase`)

## Quick Start

```bash
# 1. Clone repositori
git clone https://github.com/Dex-toxicabyss/si-akademik-rbac.git
cd si-akademik-rbac

# 2. Salin konfigurasi environment & generate application key
cp .env.example .env
php artisan key:generate

# 3. Jalankan migrasi database beserta seeder akun default
php artisan migrate --seed

# 4. Jalankan pengujian otomatis RBAC
php artisan test --filter=RbacAccessTest

# 5. Jalankan development server
php artisan serve
```

## Akun Default (`DatabaseSeeder`)

| Role | Nama Pengguna | Identifier | Email | Password |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Admin Akademik FRI | `ADM-FRI-001` | `admin@telkomuniversity.ac.id` | `password123` |
| **Dosen** | Dr. Hendra Wijaya, S.Kom., M.T. | `NIP-19880412` | `dosen@telkomuniversity.ac.id` | `password123` |
| **Mahasiswa** | Raffata Izacky Yuargya Aletama | `102042500123` | `raffata@student.telkomuniversity.ac.id` | `password123` |

## Matriks Otorisasi & Hasil Pengujian Endpoint

| Kode Uji | Role Pengguna | Endpoint | Middleware Alias | Status HTTP | Keterangan |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **TC-01** | `admin` | `GET /users` | `auth`, `role:admin` | `200 OK` | **Berhasil** — Membuka manajemen pengguna |
| **TC-02** | `admin` | `POST /users` | `auth`, `role:admin` | `200 OK` | **Berhasil** — Menambahkan pengguna baru dengan atribut `role` |
| **TC-03** | `admin` | `POST /materi` | `auth`, `role:admin,dosen` | `200 OK` | **Berhasil** — Mempublikasikan materi perkuliahan |
| **TC-04** | `admin` | `GET /nilai/manage` | `auth`, `role:admin,dosen` | `200 OK` | **Berhasil** — Mengakses manajemen nilai akademik |
| **TC-05** | `dosen` | `GET /users` | `auth`, `role:admin` | `403 Forbidden` | **Ditolak** — `CheckRole` memblokir akses Dosen ke `/users` |
| **TC-06** | `dosen` | `GET /materi` | `auth`, `role:admin,dosen,mahasiswa` | `200 OK` | **Berhasil** — Melihat daftar materi perkuliahan |
| **TC-07** | `dosen` | `POST /materi` | `auth`, `role:admin,dosen` | `200 OK` | **Berhasil** — Mengunggah materi perkuliahan baru |
| **TC-08** | `dosen` | `POST /nilai/manage` | `auth`, `role:admin,dosen` | `200 OK` | **Berhasil** — Menyimpan nilai akademik mahasiswa |
| **TC-09** | `mahasiswa` | `GET /users` | `auth`, `role:admin` | `403 Forbidden` | **Ditolak** — `CheckRole` memblokir akses Mahasiswa ke `/users` |
| **TC-10** | `mahasiswa` | `GET /materi` | `auth`, `role:admin,dosen,mahasiswa` | `200 OK` | **Berhasil** — Membaca materi perkuliahan (Read-only) |
| **TC-11** | `mahasiswa` | `POST /materi` | `auth`, `role:admin,dosen` | `403 Forbidden` | **Ditolak** — Mahasiswa diblokir saat mencoba menambah materi |
| **TC-12** | `mahasiswa` | `GET /nilai` | `auth`, `role:admin,dosen,mahasiswa` | `200 OK` | **Berhasil** — Melihat transkrip nilai pribadi |
| **TC-13** | `mahasiswa` | `GET /nilai/manage` | `auth`, `role:admin,dosen` | `403 Forbidden` | **Ditolak** — Mahasiswa diblokir dari halaman input nilai |
| **TC-14** | `guest` | `GET /dashboard` | `auth` | `302 Redirect` | **Ditolak** — Dialihkan otomatis ke halaman `/login` |

## Struktur Direktori Utama

```text
si-akademik-rbac/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AkademikController.php
│   │   │   └── AuthController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── Materi.php
│       ├── Nilai.php
│       └── User.php
├── bootstrap/
│   └── app.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_11_13_000001_create_materis_table.php
│   │   └── 2026_11_13_000002_create_nilais_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── akademik/
│   ├── auth/
│   ├── errors/403.blade.php
│   └── layouts/app.blade.php
├── routes/
│   └── web.php
├── tests/Feature/
│   └── RbacAccessTest.php
├── CONTRIBUTING.md
├── LICENSE
└── README.md
```

## Panduan Kontribusi

Silakan baca [CONTRIBUTING.md](./CONTRIBUTING.md) untuk standar penamaan branch (`feat/*`, `fix/*`, `docs/*`), konvensi commit, dan pemeriksaan pengujian sebelum membuat Pull Request.

## Lisensi

Dirilis di bawah lisensi [MIT License](./LICENSE).
