<?php

namespace App\Policies;

use App\License;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicensePolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\=License  $=License
     * @return mixed
     */
    public function view(User $user, License $license)
    {
        
        return $user->customer->id == $license->customer->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\=License  $=License
     * @return mixed
     */
    public function update(User $user, License $License)
    {
        return $user->customer->id === $license->customer->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\=License  $=License
     * @return mixed
     */
    public function delete(User $user, License $License)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\=License  $=License
     * @return mixed
     */
    public function restore(User $user, License $License)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\=License  $=License
     * @return mixed
     */
    public function forceDelete(User $user, License $License)
    {
        //
    }
    public function before($user)
    {
        return $user->is_user_admin();
    }
    public function viewOwn( User $user, $license )
    {

    }
}
