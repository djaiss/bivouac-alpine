<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UpdateUserPermission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateUserPermissionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_the_permission_of_the_user(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        $author = User::factory()->create();
        $user = User::factory()->create();
        $this->be($author);

        $user = (new UpdateUserPermission)->execute(
            user: $user,
            permissions: 'michael'
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'permissions' => 'michael',
        ]);
    }
}
