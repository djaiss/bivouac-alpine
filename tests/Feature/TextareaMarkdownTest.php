<?php

namespace Tests\Feature;

use App\Livewire\TextareaMarkdown;
use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class TextareaMarkdownTest extends TestCase
{
    /** @test */
    public function component_exists_on_the_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages/create')
            ->assertSeeLivewire(TextareaMarkdown::class);
    }

    /** @test */
    public function we_can_preview_the_markdown_version_of_the_test(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        Livewire::actingAs($user)
            ->test(TextareaMarkdown::class)
            ->set('body', 'Wrinkly fingers')
            ->call('toggle', 'preview')
            ->assertSet('previewBody', '<p>Wrinkly fingers</p>');
    }
}
