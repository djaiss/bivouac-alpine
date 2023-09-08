<?php

namespace App\Services;

use App\Models\Role;

class CreateRole extends BaseService
{
    private Role $role;
    private string $label;

    public function execute(string $label): Role
    {
        $this->label = $label;
        $this->create();

        return $this->role;
    }

    private function create(): void
    {
        // determine the new position
        $newPosition = auth()->user()->organization->roles()
            ->max('position');
        $newPosition++;

        $this->role = Role::create([
            'organization_id' => auth()->user()->organization_id,
            'label' => $this->label,
            'position' => $newPosition,
        ]);
    }
}
