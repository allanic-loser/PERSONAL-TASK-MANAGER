<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_task_dashboard(): void
    {
        $this->get('/')->assertRedirect('/tasks');
    }

    public function test_task_pages_are_available(): void
    {
        $this->get('/tasks')
            ->assertOk()
            ->assertSee('Task Dashboard');

        $this->get('/tasks/create')
            ->assertOk()
            ->assertSee('Add New Task');
    }

    public function test_task_can_be_created(): void
    {
        $data = [
            'task_name' => 'Finish Project',
            'description' => 'Complete the Laravel project.',
            'status' => 'Pending',
            'due_date' => '2026-10-10',
        ];

        $this->post('/tasks', $data)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Finish Project',
            'status' => 'Pending',
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::factory()->create();

        $this->put('/tasks/'.$task->id, [
            'task_name' => 'Updated Project',
            'description' => 'Updated description.',
            'status' => 'Completed',
            'due_date' => '2026-11-01',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Updated Project',
            'status' => 'Completed',
        ]);
    }

    public function test_task_status_can_be_changed(): void
    {
        $task = Task::factory()->create(['status' => 'Pending']);

        $this->patch('/tasks/'.$task->id.'/status', [
            'status' => 'Completed',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Completed',
        ]);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::factory()->create();

        $this->delete('/tasks/'.$task->id)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_required_fields_are_validated(): void
    {
        $this->post('/tasks', [
            'task_name' => '',
            'description' => '',
            'status' => '',
            'due_date' => '',
        ])->assertSessionHasErrors([
            'task_name',
            'status',
            'due_date',
        ]);
    }

    public function test_invalid_status_is_rejected(): void
    {
        $task = Task::factory()->create();

        $this->patch('/tasks/'.$task->id.'/status', [
            'status' => 'In Progress',
        ])->assertSessionHasErrors('status');
    }
}
