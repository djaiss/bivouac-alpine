<?php

namespace Tests\Unit\ViewModels\Users;

use App\Models\User;
use App\ViewModels\Users\UserViewModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_for_the_header(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Regis',
            'last_name' => 'Philbin',
        ]);
        $array = UserViewModel::header($user);

        $this->assertCount(3, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Regis Philbin',
                'avatar' => $user->avatar,
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_edit_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Regis',
            'last_name' => 'Philbin',
            'email' => 'regis@philippebin.com',
            'age_preferences' => User::AGE_HIDDEN,
            'born_at' => Carbon::parse('1980-01-01'),
        ]);
        $array = UserViewModel::edit($user);

        $this->assertCount(6, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'first_name' => 'Regis',
                'last_name' => 'Philbin',
                'email' => 'regis@philippebin.com',
                'born_at' => '1980-01-01',
                'age_preferences' => 'hidden',
            ],
            $array
        );
    }
}
