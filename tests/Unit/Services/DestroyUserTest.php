<?php

namespace Tests\Unit\Services;

use App\Exceptions\CantDeleteHimselfException;
use App\Models\User;
use App\Services\DestroyUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_deletes_a_user(): void
    {
        $author = User::factory()->create();
        $user = User::factory()->create();
        $this->executeService($author, $user);
    }

    /** @test */
    public function it_fails_if_user_is_the_author(): void
    {
        $author = User::factory()->create();

        $this->expectException(CantDeleteHimselfException::class);
        $this->executeService($author, $author);
    }

    private function executeService(User $author, User $user): void
    {
        $this->be($author);

        (new DestroyUser)->execute(
            user: $user
        );

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
