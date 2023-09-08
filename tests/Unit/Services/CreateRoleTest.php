<?php

namespace Tests\Unit\Services;

use App\Models\Role;
use App\Models\User;
use App\Services\CreateRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_role(): void
    {
        $author = User::factory()->create();
        $this->be($author);

        Role::factory()->create([
            'organization_id' => $author->organization_id,
            'position' => 2,
        ]);

        $role = (new CreateRole)->execute(
            label: 'Programer'
        );

        $this->assertInstanceOf(
            Role::class,
            $role
        );

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'organization_id' => $author->organization_id,
            'label' => 'Programer',
            'position' => 3,
        ]);
    }
}
