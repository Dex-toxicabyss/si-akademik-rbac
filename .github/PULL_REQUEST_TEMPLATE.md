## Deskripsi Perubahan

Ringkasan perubahan yang dilakukan pada Pull Request ini:
- [ ] Menambahkan / memperbarui migrasi tabel `users` dengan kolom `role`
- [ ] Mengimplementasikan `Middleware CheckRole` dan registrasi alias `role`
- [ ] Melindungi route `/users`, `/materi`, dan `/nilai`
- [ ] Menambahkan pengujian 3 akun (`Admin`, `Dosen`, `Mahasiswa`) dan dokumentasi hasil uji

## Hasil Pengujian

- [ ] `php artisan migrate --seed` berjalan tanpa error
- [ ] `php artisan test --filter=RbacAccessTest` lulus (200 OK & 403 Forbidden sesuai matriks)

## Referensi Issue

Closes #1
