<?php

namespace Tests\Unit\Services;

use App\Models\Organization;
use App\Models\User;
use App\Services\UpdateOrganization;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_an_organization(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        $author = User::factory()->create();
        $this->be($author);

        $organization = (new UpdateOrganization)->execute(
            name: 'Dunder'
        );

        $this->assertInstanceOf(
            Organization::class,
            $organization
        );

        $this->assertDatabaseHas('organizations', [
            'id' => $author->organization->id,
            'name' => 'Dunder',
        ]);
    }
}
