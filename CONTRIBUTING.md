# Contribution Guidelines

Terima kasih telah berkontribusi pada **si-akademik-rbac**.

## Alur Branch & Commit
1. Buat branch fitur dari `main`:
   - `feat/<nama-fitur>` untuk fitur baru (contoh: `feat/rbac-multi-role-academic`)
   - `fix/<nama-perbaikan>` untuk perbaikan bug
   - `docs/<nama-dokumen>` untuk pembaruan dokumentasi
2. Gunakan format Conventional Commits:
   - `feat(database): add users migration with role column and seeders`
   - `feat(middleware): create CheckRole middleware and register role alias`
   - `feat(rbac): implement controllers and protect routes by role`
   - `test(rbac): add PHPUnit feature tests for role authorization`

## Prasyarat Pull Request
- Pastikan `php artisan migrate:fresh --seed` dan `php artisan test --filter=RbacAccessTest` berjalan tanpa error.
- Jangan pernah menyertakan file `.env` atau kredensial ke dalam commit.
