<?php

namespace App\Services;

use App\Exceptions\CantDeleteHimselfException;
use App\Models\User;

class DestroyUser extends BaseService
{
    private User $user;

    /**
     * Delete a user.
     * A user can't delete himself.
     */
    public function execute(User $user): void
    {
        $this->user = $user;
        $this->validate();
        $this->destroy();
    }

    private function validate(): void
    {
        if ($this->user->id === auth()->user()->id) {
            throw new CantDeleteHimselfException;
        }
    }

    private function destroy(): void
    {
        $this->user->delete();
    }
}
