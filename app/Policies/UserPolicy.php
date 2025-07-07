<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Method ini berjalan SEBELUM semua method lain di policy ini.
     * Kita berikan akses penuh untuk admin dan hentikan pengecekan lebih lanjut.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null; // <-- PENTING: Jika bukan admin, kembalikan null agar pengecekan dilanjutkan ke method lain.
    }

    /**
     * Otorisasi untuk melihat daftar semua user.
     * Hanya admin yang boleh (sudah ditangani oleh 'before').
     */
    public function viewAny(User $user): bool
    {
        return false; // Secara default, non-admin tidak boleh.
    }

    /**
     * Otorisasi untuk melihat detail user tertentu.
     */
    public function view(User $user, User $model): bool
    {
        // User bisa melihat profilnya sendiri.
        return $user->id === $model->id;
    }

    /**
     * Otorisasi untuk membuat user baru.
     * Hanya admin yang boleh (sudah ditangani oleh 'before').
     */
    public function create(User $user): bool
    {
        return false; // Secara default, non-admin tidak boleh.
    }

    /**
     * Otorisasi untuk mengupdate user.
     */
    public function update(User $user, User $model): bool
    {
        // User bisa mengupdate profilnya sendiri (penting untuk halaman profil bawaan Breeze).
        return $user->id === $model->id;
    }

    /**
     * Otorisasi untuk menghapus user.
     */
    public function delete(User $user, User $model): bool
    {
        // User tidak boleh menghapus dirinya sendiri, bahkan admin sekalipun.
        // Aturan ini akan dievaluasi bahkan untuk admin karena tidak ada 'true' di 'before'.
        if ($user->id === $model->id) {
            return false;
        }

        // Untuk kasus lain, admin sudah diizinkan oleh method 'before'.
        // Non-admin akan ditolak di sini.
        return false;
    }
}

