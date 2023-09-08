<?php

namespace Tests\Unit\Services;

use App\Models\Office;
use App\Models\User;
use App\Services\UpdateOffice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_an_office(): void
    {
        $office = Office::factory()->create();
        $this->executeService($office);
    }

    private function executeService(Office $office): void
    {
        $author = User::factory()->create([
            'organization_id' => $office->organization_id,
        ]);
        $this->be($author);

        $office = (new UpdateOffice)->execute(
            office: $office,
            name: 'Dunder',
            isMainOffice: true
        );

        $this->assertInstanceOf(
            Office::class,
            $office
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'organization_id' => $author->organization_id,
            'name' => 'Dunder',
            'is_main_office' => true,
        ]);
    }
}
