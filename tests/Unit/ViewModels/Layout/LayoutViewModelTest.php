<?php

namespace Tests\Unit\ViewModels\Layout;

use App\Models\User;
use App\ViewModels\Layout\LayoutViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayoutViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'name_for_avatar' => 'michael',
        ]);

        $array = LayoutViewModel::data($user);

        $this->assertFalse(
            $array['can_manage_settings']
        );
        $this->assertEquals(
            $user->avatar,
            $array['avatar']
        );
        $this->assertEquals(
            'Michael Scott',
            $array['name']
        );
        $this->assertEquals(
            'Dunder Mifflin',
            $array['organization']
        );
        $this->assertEquals(
            'en',
            $array['current_locale']
        );
        $this->assertEquals(
            [
                0 => [
                    'name' => 'English',
                    'shortCode' => 'en',
                    'url' => config('app.url') . '/locale/en',
                ],
                1 => [
                    'name' => 'Français',
                    'shortCode' => 'fr',
                    'url' => config('app.url') . '/locale/fr',
                ],
            ],
            $array['locales']->toArray()
        );
    }
}
