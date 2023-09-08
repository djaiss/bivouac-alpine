<?php

namespace App\Services;

use App\Models\Office;

class CreateOffice extends BaseService
{
    private Office $office;
    private bool $isMainOffice;

    public function execute(string $name, bool $isMainOffice): Office
    {
        $this->isMainOffice = $isMainOffice;

        $this->office = Office::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $name,
            'is_main_office' => $isMainOffice,
        ]);

        $this->toggleMainOfficeForAllTheOtherOffices();

        return $this->office;
    }

    private function toggleMainOfficeForAllTheOtherOffices(): void
    {
        if ($this->isMainOffice) {
            Office::where('organization_id', auth()->user()->organization_id)
                ->whereNot('id', $this->office->id)
                ->update([
                    'is_main_office' => false,
                ]);
        }
    }
}
