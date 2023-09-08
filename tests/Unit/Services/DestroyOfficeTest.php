<?php

namespace Tests\Unit\Services;

use App\Models\Office;
use App\Services\DestroyOffice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_an_office(): void
    {
        $office = Office::factory()->create();
        $this->executeService($office);
    }

    private function executeService(Office $office): void
    {
        (new DestroyOffice)->execute($office);

        $this->assertDatabaseMissing('offices', [
            'id' => $office->id,
        ]);
    }
}
