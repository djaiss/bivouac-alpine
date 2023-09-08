<?php

namespace App\Services;

use App\Models\Role;

class DestroyRole extends BaseService
{
    private Role $role;

    public function execute(Role $role): void
    {
        $this->role = $role;
        $this->updatePosition();
        $this->destroy();
    }

    private function destroy(): void
    {
        $this->role->delete();
    }

    private function updatePosition(): void
    {
        auth()->user()->organization->roles()
            ->where('position', '>', $this->role->position)
            ->decrement('position');
    }
}
