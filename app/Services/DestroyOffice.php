<?php

namespace App\Services;

use App\Models\Office;

class DestroyOffice extends BaseService
{
    public function execute(Office $office): void
    {
        $office->delete();
    }
}
