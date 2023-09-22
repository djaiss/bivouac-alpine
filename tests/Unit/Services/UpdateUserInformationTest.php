<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateUserInformationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_the_information_of_the_user(): void
    {
        $user = User::factory()->create();
        Event::fake();
        $this->be($user);

        $user = (new UpdateUserInformation)->execute(
            user: $user,
            firstName: 'michael',
            lastName: 'scott',
            email: 'michael@dunder.com',
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'michael',
            'last_name' => 'scott',
        ]);

        Event::assertDispatched(Registered::class);
    }
}
