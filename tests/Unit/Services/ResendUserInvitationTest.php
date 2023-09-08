<?php

namespace Tests\Unit\Services;

use App\Mail\UserInvited;
use App\Models\User;
use App\Services\ResendUserInvitation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ResendUserInvitationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sends_a_new_invite(): void
    {
        $author = User::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $author->organization_id,
        ]);
        $this->executeService($author, $user);
    }

    private function executeService(User $author, User $user): void
    {
        Mail::fake();
        $this->be($author);

        $newUser = (new ResendUserInvitation)->execute(
            user: $user
        );

        $this->assertInstanceOf(
            User::class,
            $newUser
        );

        $this->assertDatabaseHas('users', [
            'id' => $newUser->id,
            'email' => $newUser->email,
            'permissions' => User::ROLE_USER,
            'organization_id' => $author->organization_id,
            'invitation_code' => $newUser->invitation_code,
        ]);

        Mail::assertQueued(UserInvited::class, function ($mail) use ($newUser) {
            return $mail->hasTo($newUser->email);
        });
    }
}
