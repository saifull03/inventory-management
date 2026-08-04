<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_employees(): void
    {
        $response = $this->get(route('employees.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_employees_list(): void
    {
        $user = User::factory()->create();
        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'John Doe',
            'department' => 'Engineering',
            'designation' => 'Software Engineer',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
        ]);

        $response = $this->actingAs($user)->get(route('employees.index'));

        $response->assertStatus(200);
        $response->assertSee('EMP-001');
        $response->assertSee('John Doe');
    }

    public function test_authenticated_user_can_create_employee(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('employees.store'), [
                'employee_id' => 'EMP-002',
                'name' => 'Jane Smith',
                'department' => 'HR',
                'designation' => 'Recruiter',
                'email' => 'jane.smith@example.com',
                'phone' => '+0987654321',
            ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'employee_id' => 'EMP-002',
            'name' => 'Jane Smith',
        ]);
    }

    public function test_employee_validation_rules(): void
    {
        $user = User::factory()->create();

        // Unique Employee ID and Email
        Employee::create([
            'employee_id' => 'EMP-003',
            'name' => 'Bob Builder',
            'department' => 'Construction',
            'designation' => 'Builder',
            'email' => 'bob@example.com',
        ]);

        $response = $this->actingAs($user)
            ->post(route('employees.store'), [
                'employee_id' => 'EMP-003',
                'name' => 'Another Bob',
                'department' => 'Construction',
                'designation' => 'Builder',
                'email' => 'bob@example.com',
            ]);

        $response->assertSessionHasErrors(['employee_id', 'email']);
    }

    public function test_authenticated_user_can_update_employee(): void
    {
        $user = User::factory()->create();
        $employee = Employee::create([
            'employee_id' => 'EMP-004',
            'name' => 'Alice Cooper',
            'department' => 'Music',
            'designation' => 'Vocalist',
            'email' => 'alice@example.com',
        ]);

        $response = $this->actingAs($user)
            ->put(route('employees.update', $employee), [
                'employee_id' => 'EMP-004-UPDATED',
                'name' => 'Alice Cooper Updated',
                'department' => 'Music',
                'designation' => 'Vocalist',
                'email' => 'alice.new@example.com',
                'phone' => '555-1234',
            ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'employee_id' => 'EMP-004-UPDATED',
            'name' => 'Alice Cooper Updated',
            'phone' => '555-1234',
        ]);
    }

    public function test_authenticated_user_can_delete_employee(): void
    {
        $user = User::factory()->create();
        $employee = Employee::create([
            'employee_id' => 'EMP-005',
            'name' => 'Charlie Brown',
            'department' => 'Cartoons',
            'designation' => 'Main Character',
            'email' => 'charlie@example.com',
        ]);

        $response = $this->actingAs($user)
            ->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    public function test_employee_search_works(): void
    {
        $user = User::factory()->create();
        Employee::create([
            'employee_id' => 'EMP-006',
            'name' => 'UniqueSearchName',
            'department' => 'Science',
            'designation' => 'Researcher',
            'email' => 'researcher@example.com',
        ]);
        Employee::create([
            'employee_id' => 'EMP-007',
            'name' => 'Another Guy',
            'department' => 'Art',
            'designation' => 'Painter',
            'email' => 'painter@example.com',
        ]);

        $response = $this->actingAs($user)
            ->get(route('employees.index', ['search' => 'UniqueSearchName']));

        $response->assertStatus(200);
        $response->assertSee('UniqueSearchName');
        $response->assertDontSee('Another Guy');
    }
}
