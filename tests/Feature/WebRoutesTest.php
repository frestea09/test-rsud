<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /** @test */

    /** @test */


    /** @test */
    public function it_generates_pdf()
    {
        $response = $this->post(route('generate.pdf'));
        $response->assertStatus(200);
        $this->assertEquals('ganteng', $response->getContent());
    }

    /** @test */
    /** @test */
    public function it_creates_a_user()
    {
        $this->actingAs(\App\Models\User::factory()->create());

        $response = $this->post(route('users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    /** @test */
    public function it_edits_a_user()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $userToEdit = \App\Models\User::factory()->create();

        $response = $this->get(route('users.edit', $userToEdit->id));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $userToUpdate = \App\Models\User::factory()->create();

        $response = $this->put(route('users.update', $userToUpdate->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
}