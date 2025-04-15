<?php

namespace App\Policies;

use App\Models\Detailpenjualan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DetailpenjualanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator'
        || $user->role == 'supervisor'
        || $user->role == 'kasir';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Detailpenjualan $detailpenjualan): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator'
        || $user->role == 'supervisor'
        || $user->role == 'kasir';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator'
        || $user->role == 'supervisor'
        || $user->role == 'kasir';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Detailpenjualan $detailpenjualan): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator'
        || $user->role == 'supervisor'
        || $user->role == 'kasir';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Detailpenjualan $detailpenjualan): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator';
    }
    public function deleteAny(User $user): bool
    {
        return $user->email == 'michael@owner.com';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Detailpenjualan $detailpenjualan): bool
    {
        return $user->email == 'michael@owner.com'
        || $user->role == 'administrator';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Detailpenjualan $detailpenjualan): bool
    {
        return $user->email == 'michael@owner.com';
    }
}
