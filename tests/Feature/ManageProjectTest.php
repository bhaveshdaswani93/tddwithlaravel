<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_project()
    {
        $attributes = Project::factory()->raw();
        $project = Project::factory()->create();
        $this->get('projects')->assertRedirect('login');
        $this->get('projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    // public function a_project_has_an_owner()
    // public function guests_cannot_create_project()
    // {
    // }

    /** @test */
    public function a_user_can_create_a_project()
    {
        //        $this->expectError();
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('projects/create')->assertStatus(200);
        // $attributes = ['title' => $this->faker->title, 'description' => $this->faker->sentence];
        $attributes = Project::factory()->raw();
        unset($attributes['owner_id']);
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);




        //        $response->assertStatus(201);
    }

    /** @test */
    // public function guest_cannot_view_projects()
    // {
    // }

    /** @test */
    // public function guest_cannot_view_single_project()
    // {
    // }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['title' => '']);
        // dd($attributes);
        $this->post('/projects', $attributes)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test  */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->actingAs(User::factory()->create());
        $project = Project::factory()->create();
        $this->get($project->path())->assertStatus(403);
    }
}
