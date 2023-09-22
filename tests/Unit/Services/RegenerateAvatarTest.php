<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\RegenerateAvatar;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegenerateAvatarTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_generates_a_new_avatar_username(): void
    {
        $user = User::factory()->create();
        $previousName = $user->name_for_avatar;

        $user = (new RegenerateAvatar)->execute($user);

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name_for_avatar' => $previousName,
        ]);
    }
}
