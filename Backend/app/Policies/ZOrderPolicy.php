<?php

namespace App\Policies;

use TCG\Voyager\Policies\BasePolicy;

use App\User;

class ZOrderPolicy extends BasePolicy
{
    /**
     * Determine if the given model can be viewed by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function read(User $user, $model)
    {
        return $this->checkPermission($user, $model, 'read');
    }

    /**
     * Determine if the given model can be edited by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function edit(User $user, $model)
    {
        return $this->checkPermission($user, $model, 'edit');
    }

    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function delete(User $user, $model)
    {
        return $this->checkPermission($user, $model, 'delete');
    }
}
