<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     * Method ini untuk halaman index (daftar produk).
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     * Method ini untuk halaman detail produk.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     * Method ini untuk halaman create & proses store.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     * Method ini untuk halaman edit & proses update.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     * Method ini untuk proses delete.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    // ... method restore & forceDelete bisa diabaikan untuk saat ini ...
}

