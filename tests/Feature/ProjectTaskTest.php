<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        // $project = auth()->user()->projects()->create()
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $attributes = Task::factory()->raw();
        $this->post($project->path() . '/tasks', $attributes);
        $this->assertDatabaseHas('tasks', $attributes);
        // $this->();
        $this->get($project->path())->assertSee($attributes['body']);
    }
    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(Project::factory()->raw());
        $attributes = Task::factory()->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
