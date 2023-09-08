<?php

namespace App\Services;

use App\Models\Role;

class UpdateRole extends BaseService
{
    private Role $role;
    private string $label;
    private int $pastPosition;
    private int $newPosition;

    public function execute(
        Role $role,
        string $label,
        int $position
    ): Role {
        $this->role = $role;
        $this->label = $label;
        $this->pastPosition = $role->position;
        $this->newPosition = $position;
        $this->update();
        $this->updatePosition();

        return $this->role;
    }

    private function update(): void
    {
        $this->role->update([
            'label' => $this->label,
        ]);
    }

    private function updatePosition(): void
    {
        if ($this->newPosition > $this->pastPosition) {
            $this->updateAscendingPosition();
        } else {
            $this->updateDescendingPosition();
        }

        $this->role->update([
            'position' => $this->newPosition,
        ]);
    }

    private function updateAscendingPosition(): void
    {
        auth()->user()->organization->roles()
            ->where('position', '>', $this->pastPosition)
            ->where('position', '<=', $this->newPosition)
            ->decrement('position');
    }

    private function updateDescendingPosition(): void
    {
        auth()->user()->organization->roles()
            ->where('position', '>=', $this->newPosition)
            ->where('position', '<', $this->pastPosition)
            ->increment('position');
    }
}
