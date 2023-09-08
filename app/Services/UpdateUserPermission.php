<?php

namespace App\Services;

use App\Models\User;

class UpdateUserPermission extends BaseService
{
    private string $permissions;
    private User $user;

    public function execute(User $user, string $permissions): User
    {
        $this->user = $user;
        $this->permissions = $permissions;
        $this->update();

        return $this->user;
    }

    private function update(): void
    {
        $this->user->permissions = $this->permissions;
        $this->user->save();
    }
}
