<?php

namespace App\Policies;

use App\Models\Ambulance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AmbulancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ambulance $ambulance): bool
    {
        // return $user->role === 'doctor' //|| $user->role === 'super-admin
        //     ? Response::allow()
        //     : Response::deny('You do not have permission to view an ambulance');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return $user->role === 'super-admin'
        //     ? Response::allow()
        //     : Response::deny('You do not have permission to create an ambulance');
        // return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ambulance $ambulance): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ambulance $ambulance): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ambulance $ambulance): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ambulance $ambulance): bool
    {
        //
    }
}
