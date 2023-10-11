<?php

namespace Tests\Unit\ViewModels;

use App\Models\Reaction;
use App\Models\User;
use App\ViewModels\ReactionViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReactionViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_dto(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'name_for_avatar' => 'John Doe',
        ]);
        $reaction = Reaction::factory()->create([
            'user_id' => $user->id,
            'emoji' => '👍',
        ]);
        $array = ReactionViewModel::dto($reaction);

        $this->assertCount(3, $array);
        $this->assertArrayHasKey('author', $array);

        $this->assertEquals(
            [
                'id' => $reaction->id,
                'emoji' => '👍',
                'author' => [
                    'id' => $user->id,
                    'name' => 'Michael Scott',
                    'avatar' => $user->avatar,
                ],
            ],
            $array
        );
    }
}
