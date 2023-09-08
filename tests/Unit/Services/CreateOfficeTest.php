<?php

namespace Tests\Unit\Services;

use App\Models\Office;
use App\Models\User;
use App\Services\CreateOffice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_office(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        $author = User::factory()->create();
        $this->be($author);

        $office = (new CreateOffice)->execute(
            name: 'Dunder',
            isMainOffice: true,
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
