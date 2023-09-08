<?php

namespace Tests\Unit\Services;

use App\Mail\UserInvited;
use App\Models\User;
use App\Services\InviteUser;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InviteUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_invites_another_user(): void
    {
        $this->executeService();
    }

    /** @test */
    public function it_fails_if_email_is_already_taken(): void
    {
        User::factory()->create([
            'email' => 'admin@admin.com',
        ]);
        $this->expectException(UniqueConstraintViolationException::class);
        $this->executeService();
    }

    private function executeService(): void
    {
        Mail::fake();
        $author = User::factory()->create();
        $this->be($author);

        $newUser = (new InviteUser)->execute(
            email: 'admin@admin.com'
        );

        $this->assertInstanceOf(
            User::class,
            $newUser
        );

        $this->assertDatabaseHas('users', [
            'id' => $newUser->id,
            'email' => 'admin@admin.com',
            'permissions' => User::ROLE_USER,
            'organization_id' => $author->organization_id,
            'invitation_code' => $newUser->invitation_code,
        ]);

        Mail::assertQueued(UserInvited::class, function ($mail) use ($newUser) {
            return $mail->hasTo($newUser->email);
        });
    }
}
