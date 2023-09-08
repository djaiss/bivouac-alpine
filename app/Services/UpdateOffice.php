<?php

namespace App\Services;

use App\Models\Office;

class UpdateOffice extends BaseService
{
    private Office $office;
    private string $name;
    private bool $isMainOffice;

    public function execute(
        Office $office,
        string $name,
        bool $isMainOffice
    ): Office {
        $this->office = $office;
        $this->name = $name;
        $this->isMainOffice = $isMainOffice;

        $this->edit();
        $this->toggleMainOfficeForAllTheOtherOffices();

        return $this->office;
    }

    private function edit(): void
    {
        $this->office->name = $this->name;
        $this->office->is_main_office = $this->isMainOffice;
        $this->office->save();
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
