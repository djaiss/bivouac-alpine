<?php

namespace App\Services;

use App\Mail\UserInvited;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteUser extends BaseService
{
    private string $email;
    private User $user;

    /**
     * Invite someone to the organization using the email address provided.
     */
    public function execute(string $email): User
    {
        $this->email = $email;
        $this->create();
        $this->sendEmail();

        return $this->user;
    }

    private function create(): void
    {
        $this->user = User::create([
            'email' => $this->email,
            'permissions' => User::ROLE_USER,
            'name_for_avatar' => fake()->name,
            'organization_id' => auth()->user()->organization_id,
            'invitation_code' => (string) Str::uuid(),
        ]);
    }

    private function sendEmail(): void
    {
        Mail::to($this->email)
            ->queue(new UserInvited($this->user, auth()->user()));
    }
}
