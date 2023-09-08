<?php

namespace App\Services;

use App\Mail\UserInvited;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResendUserInvitation extends BaseService
{
    private User $user;

    /**
     * Resend the invitation to a user.
     */
    public function execute(User $user): User
    {
        $this->user = $user;
        $this->regenerateCode();
        $this->sendEmail();

        return $this->user;
    }

    private function regenerateCode(): void
    {
        $this->user->update([
            'invitation_code' => (string) Str::uuid(),
        ]);
    }

    private function sendEmail(): void
    {
        Mail::to($this->user->email)
            ->queue(new UserInvited($this->user->refresh(), auth()->user()));
    }
}
