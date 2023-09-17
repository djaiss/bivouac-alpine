<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Project;
use App\Models\User;
use App\ViewModels\Projects\ProjectMemberViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectMemberViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $project->users()->attach($user->id);
        $array = ProjectMemberViewModel::index($project);

        $this->assertCount(2, $array);
        $this->assertArrayHasKey('members', $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertEquals(
            $project->id,
            $array['project_id']
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_delete_view(): void
    {
        $user = User::factory()->create();
        $array = ProjectMemberViewModel::delete($user);

        $this->assertCount(3, $array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('avatar', $array);
    }

    /** @test */
    public function it_gets_the_dto(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);
        $project = Project::factory()->create();
        $array = ProjectMemberViewModel::dto($user, $project);

        $this->assertCount(3, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Michael Scott',
                'avatar' => $user->avatar,
            ],
            $array
        );
    }

    /** @test */
    public function it_returns_an_empty_array_if_there_are_no_new_users_to_search_for(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $collection = ProjectMemberViewModel::listUsers($user, $project);

        $this->assertEquals(0, $collection->count());
    }

    /** @test */
    public function it_gets_the_list_of_users_who_are_not_part_of_the_project_yet(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $notYetUser = User::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $project->users()->attach($user->id);
        $collection = ProjectMemberViewModel::listUsers($user, $project);

        $this->assertEquals(
            [
                0 => [
                    'id' => $notYetUser->id,
                    'name' => $notYetUser->name,
                    'avatar' => $notYetUser->avatar,
                ],
            ],
            $collection->toArray()
        );
    }
}
