<?php

namespace App\Services;

use App\Models\User;

class RegenerateAvatar extends BaseService
{
    /**
     * Update the user's default avatar.
     * The default avatar is based on the username.
     * This method creates a new random username so the avatar looks different.
     */
    public function execute(User $user): User
    {
        $user->name_for_avatar = fake()->name;
        $user->save();

        return $user;
    }
}
