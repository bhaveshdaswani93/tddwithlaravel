<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{

    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
//        $this->expectError();
        $this->withoutExceptionHandling();

        $attributes = ['title' => $this->faker->title, 'description' => $this->faker->sentence];

        $response = $this->post('/project',$attributes);

        $this->assertDatabaseHas('projects',$attributes);


//        $response->assertStatus(201);
    }
}
