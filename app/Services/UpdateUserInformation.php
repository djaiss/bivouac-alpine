<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UpdateUserInformation extends BaseService
{
    /**
     * Update the information about the user.
     */
    public function execute(
        User $user,
        string $firstName,
        string $lastName,
        string $email
    ): User {
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->save();

        if ($user->email !== $email) {
            $user->email_verified_at = null;
            $user->email = $email;
            $user->save();

            event(new Registered($user instanceof MustVerifyEmail));
        }

        return $user;
    }
}
