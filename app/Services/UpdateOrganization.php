<?php

namespace App\Services;

use App\Models\Organization;

class UpdateOrganization extends BaseService
{
    private string $name;

    public function execute(string $name): Organization
    {
        $this->name = $name;
        $this->edit();

        return auth()->user()->organization;
    }

    private function edit(): void
    {
        auth()->user()->organization->name = $this->name;
        auth()->user()->organization->save();
    }
}
