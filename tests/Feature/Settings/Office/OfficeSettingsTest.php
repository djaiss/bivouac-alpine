<?php

namespace Tests\Feature\Settings\Office;

use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficeSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_page_lists_a_list_of_offices(): void
    {
        $office = Office::factory()->create([
            'name' => 'Paris',
            'is_main_office' => true,
        ]);
        $administrator = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
            'organization_id' => $office->organization_id,
        ]);
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $office->organization_id,
        ]);

        $this->actingAs($user)
            ->get('/settings/offices')
            ->assertStatus(401);

        $this->actingAs($administrator)
            ->get('/settings/offices')
            ->assertStatus(200);

        $this->actingAs($administrator)
            ->get('/settings/offices')
            ->assertSee('Paris');
    }

    /** @test */
    public function an_administrator_can_create_a_new_office(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->post('/settings/offices', [
                'name' => fake()->name,
            ])
            ->assertStatus(401);

        $user = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        $this->actingAs($user)
            ->post('/settings/offices', [
                'name' => 'Dunder',
            ])
            ->assertRedirectToRoute('settings.office.index');

        $this->actingAs($user)
            ->get('/settings/offices')
            ->assertSee('Dunder');
    }

    /** @test */
    public function an_office_can_be_edited(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $office = Office::factory()->create([
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->put('/settings/offices/' . $office->id, [
                'name' => 'Dunder',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('settings.office.index');
    }

    /** @test */
    public function an_office_cant_be_edited(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);
        $office = Office::factory()->create([
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->put('/settings/offices/' . $office->id, [
                'name' => 'Dunder',
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function an_office_can_be_deleted(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $office = Office::factory()->create([
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->get('/settings/offices/' . $office->id . '/delete')
            ->assertStatus(200);

        $this->actingAs($john)
            ->delete('/settings/offices/' . $office->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('settings.office.index');
    }

    /** @test */
    public function an_office_cant_be_deleted(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);
        $office = Office::factory()->create([
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->get('/settings/offices/' . $office->id . '/delete')
            ->assertStatus(401);

        $this->actingAs($john)
            ->delete('/settings/offices/' . $office->id)
            ->assertStatus(401);
    }
}
