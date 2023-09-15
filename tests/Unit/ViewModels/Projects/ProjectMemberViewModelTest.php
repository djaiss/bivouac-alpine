<?php

namespace Tests\Unit\ViewModels\Projects;

use App\ViewModels\Projects\ProjectMemberViewModel;
use App\Models\Project;
use App\Models\User;
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
        $this->assertArrayHasKey('project', $array);
        $this->assertArrayHasKey('members', $array);
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
        $array = ProjectMemberViewModel::listUsers($user, $project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('users', $array);

        $this->assertCount(0, $array['users']);
    }

    /** @test */
    public function it_gets_the_list_of_users_who_are_not_part_of_the_project_yet(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        User::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $project->users()->attach($user->id);
        $array = ProjectMemberViewModel::listUsers($user, $project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('users', $array);

        $this->assertCount(1, $array['users']);
    }
}
