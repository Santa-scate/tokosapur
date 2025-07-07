<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    // Berikan semua hak akses ke admin
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    // Secara default tolak semua untuk non-admin
    public function viewAny(User $user): bool { return false; }
    public function view(User $user, Customer $customer): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, Customer $customer): bool { return false; }
    public function delete(User $user, Customer $customer): bool { return false; }
}

