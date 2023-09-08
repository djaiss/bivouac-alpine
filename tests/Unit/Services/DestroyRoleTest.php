<?php

namespace Tests\Unit\Services;

use App\Models\Role;
use App\Models\User;
use App\Services\DestroyRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyRoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_role(): void
    {
        $author = User::factory()->create();
        $this->be($author);

        $role1 = Role::factory()->create([
            'organization_id' => $author->organization_id,
            'position' => 1,
        ]);
        $role2 = Role::factory()->create([
            'organization_id' => $author->organization_id,
            'position' => 2,
        ]);
        $role3 = Role::factory()->create([
            'organization_id' => $author->organization_id,
            'position' => 3,
        ]);

        (new DestroyRole)->execute(
            role: $role2,
        );

        $this->assertInstanceOf(
            Role::class,
            $role2
        );

        $this->assertDatabaseHas('roles', [
            'id' => $role1->id,
            'position' => 1,
        ]);
        $this->assertDatabaseMissing('roles', [
            'id' => $role2->id,
        ]);
        $this->assertDatabaseHas('roles', [
            'id' => $role3->id,
            'position' => 2,
        ]);
    }
}
