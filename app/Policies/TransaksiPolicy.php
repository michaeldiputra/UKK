<?php

namespace App\Policies;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Auth\Access\Response;

class TransaksiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator' 
        || $user->role == 'pelanggan';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaksi $transaksi): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator' 
        || $user->role == 'pelanggan';
        
    }

    public function create(User $user): bool
    {
        return $user->email == 'michael@owner.com';
    }

    public function update(User $user, Transaksi $transaksi): bool
    {
        return $user->email == 'michael@owner.com';
    }

    public function delete(User $user, Transaksi $transaksi): bool
    {
        return $user->email == 'michael@owner.com';
    }
    
    public function deleteAny(User $user): bool
    {
        return $user->email == 'michael@owner.com';
    }

    public function restore(User $user, Transaksi $transaksi): bool
    {
        return $user->email == 'michael@owner.com';
    }

    public function forceDelete(User $user, Transaksi $transaksi): bool
    {
        return $user->email == 'michael@owner.com';
    }
}