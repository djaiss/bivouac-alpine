<?php

namespace Tests\Unit\ViewModels\Settings;

use App\Models\User;
use App\ViewModels\Settings\SettingsUserViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsUserViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create();
        $array = SettingsUserViewModel::index($user);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('users', $array);
    }

    /** @test */
    public function it_gets_the_dto_for_user(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'name_for_avatar' => 'Ross',
            'email' => 'ross.geller@gmail.com',
            'email_verified_at' => '2021-01-01 00:00:00',
        ]);
        $array = SettingsUserViewModel::dto($user, $user);

        $this->assertCount(8, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Ross Geller',
                'avatar' => $user->avatar,
                'email' => 'ross.geller@gmail.com',
                'verified' => true,
                'can_delete' => false,
                'permissions' => 'User',
                'url' => [
                    'send' => env('APP_URL') . '/settings/users/' . $user->id . '/send',
                    'edit' => env('APP_URL') . '/settings/users/' . $user->id . '/edit',
                    'delete' => env('APP_URL') . '/settings/users/' . $user->id . '/delete',
                ],
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_edit_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'permissions' => 'user',
            'name_for_avatar' => 'Ross',
        ]);
        $array = SettingsUserViewModel::edit($user);

        $this->assertCount(5, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Ross Geller',
                'avatar' => $user->avatar,
                'permissions' => 'user',
                'url' => [
                    'update' => env('APP_URL') . '/settings/users/' . $user->id,
                ],
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_delete_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $array = SettingsUserViewModel::delete($user);

        $this->assertCount(3, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Ross Geller',
                'url' => [
                    'destroy' => env('APP_URL') . '/settings/users/' . $user->id,
                ],
            ],
            $array
        );
    }
}
