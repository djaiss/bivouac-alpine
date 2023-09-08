<?php

namespace Tests\Unit\ViewModels\Auth;

use App\Models\User;
use App\ViewModels\Auth\ValidateInvitationViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ValidateInvitationViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create([
            'invitation_code' => 'john',
        ]);

        $array = ValidateInvitationViewModel::data($user);

        $this->assertEquals(
            [
                'url' => [
                    'store' => env('APP_URL') . '/invitation/john',
                ],
            ],
            $array
        );
    }
}
