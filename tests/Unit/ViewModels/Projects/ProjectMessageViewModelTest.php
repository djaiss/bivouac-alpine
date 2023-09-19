<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\ViewModels\Projects\ProjectMessageViewModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProjectMessageViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $project = Project::factory()->create(['name' => 'Dunder']);
        $newAndReadMessage = Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'New and read',
            'created_at' => Carbon::create(2018, 1, 1),
        ]);
        $oldAndUnreadMessage = Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'Old and unread',
            'created_at' => Carbon::create(2011, 1, 1),
        ]);
        DB::table('message_read_status')->insert([
            'message_id' => $newAndReadMessage->id,
            'user_id' => $user->id,
        ]);

        $array = ProjectMessageViewModel::index($project);

        $this->assertCount(2, $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertArrayHasKey('messages', $array);
        $this->assertEquals(
            [
                0 => [
                    'id' => $newAndReadMessage->id,
                    'title' => 'New and read',
                    'read' => true,
                    'author' => [
                        'name' => $newAndReadMessage->authorName,
                        'avatar' => $newAndReadMessage?->creator?->avatar,
                    ],
                ],
                1 => [
                    'id' => $oldAndUnreadMessage->id,
                    'title' => 'Old and unread',
                    'read' => false,
                    'author' => [
                        'name' => $oldAndUnreadMessage->authorName,
                        'avatar' => $oldAndUnreadMessage?->creator?->avatar,
                    ],
                ],
            ],
            $array['messages']->toArray()
        );
    }

    /** @test */
    public function it_gets_the_create_view(): void
    {
        $project = Project::factory()->create();

        $array = ProjectMessageViewModel::create($project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertEquals(['project_id' => $project->id], $array);
    }
}
