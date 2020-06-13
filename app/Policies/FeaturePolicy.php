<?php

namespace App\Policies;

use App\Feature;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_user_admin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Feature  $feature
     * @return mixed
     */
    public function view(User $user, Feature $feature)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Feature  $feature
     * @return mixed
     */
    public function update(User $user, Feature $feature)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Feature  $feature
     * @return mixed
     */
    public function delete(User $user, Feature $feature)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Feature  $feature
     * @return mixed
     */
    public function restore(User $user, Feature $feature)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Feature  $feature
     * @return mixed
     */
    public function forceDelete(User $user, Feature $feature)
    {
        //
    }
    public function before( $user )
    {
        return $user->is_user_admin();
    }
}
