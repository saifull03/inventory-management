<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Employee;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAssignmentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Warehouse $warehouse;
    private Category $category;
    private ItemType $itemType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);

        $this->warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
        ]);

        $this->category = Category::create([
            'name' => 'Hardware',
            'prefix' => 'HW',
        ]);

        $this->itemType = ItemType::create([
            'name' => 'Laptop',
            'prefix' => 'LT',
        ]);
    }

    public function test_unauthenticated_user_cannot_assign_employee_to_product(): void
    {
        $product = Product::create([
            'product_code' => 'LT0001',
            'name' => 'ThinkPad',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Available',
        ]);

        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'John Doe',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'john@example.com',
        ]);

        $response = $this->patch(route('products.assign', $product), [
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_assign_employee_to_product(): void
    {
        $product = Product::create([
            'product_code' => 'LT0001',
            'name' => 'ThinkPad',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Available',
        ]);

        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'John Doe',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($this->user)->patch(route('products.assign', $product), [
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'employee_id' => $employee->id,
            'status' => 'Assigned',
        ]);
    }

    public function test_authenticated_user_can_create_product_with_employee(): void
    {
        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'John Doe',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($this->user)->post(route('products.store'), [
            'name' => 'ThinkPad X1',
            'brand' => 'Lenovo',
            'model' => 'Carbon',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'status' => 'Available',
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'ThinkPad X1',
            'employee_id' => $employee->id,
            'status' => 'Assigned',
        ]);
    }

    public function test_authenticated_user_can_update_product_with_employee(): void
    {
        $product = Product::create([
            'product_code' => 'LT0001',
            'name' => 'ThinkPad',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Available',
        ]);

        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'John Doe',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($this->user)->put(route('products.update', $product), [
            'name' => 'ThinkPad Updated',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'status' => 'Available', // Select field says Available but setting employee should set status to Assigned in DB
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'ThinkPad Updated',
            'employee_id' => $employee->id,
            'status' => 'Assigned',
        ]);
    }

    public function test_product_search_by_employee_works(): void
    {
        $employee1 = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'Alice Smith',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'alice@example.com',
        ]);

        $employee2 = Employee::create([
            'employee_id' => 'EMP-002',
            'name' => 'Bob Builder',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'bob@example.com',
        ]);

        $product1 = Product::create([
            'product_code' => 'LT0001',
            'name' => 'UniqueLaptop',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Assigned',
            'employee_id' => $employee1->id,
        ]);

        $product2 = Product::create([
            'product_code' => 'LT0002',
            'name' => 'AnotherLaptop',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Assigned',
            'employee_id' => $employee2->id,
        ]);

        // Search by employee name
        $response = $this->actingAs($this->user)->get(route('products.index', ['search' => 'Alice']));
        $response->assertStatus(200);
        $response->assertSee('UniqueLaptop');
        $response->assertDontSee('AnotherLaptop');

        // Search by employee ID
        $response = $this->actingAs($this->user)->get(route('products.index', ['search' => 'EMP-002']));
        $response->assertStatus(200);
        $response->assertSee('AnotherLaptop');
        $response->assertDontSee('UniqueLaptop');
    }

    public function test_cannot_delete_assigned_product(): void
    {
        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'Alice Smith',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'alice@example.com',
        ]);

        $product = Product::create([
            'product_code' => 'LT0001',
            'name' => 'Laptop One',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Assigned',
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('error', 'Cannot delete product because it is currently assigned to an employee.');
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_cannot_delete_employee_with_assigned_products(): void
    {
        $employee = Employee::create([
            'employee_id' => 'EMP-001',
            'name' => 'Alice Smith',
            'department' => 'IT',
            'designation' => 'Support',
            'email' => 'alice@example.com',
        ]);

        $product = Product::create([
            'product_code' => 'LT0001',
            'name' => 'Laptop One',
            'brand' => 'Lenovo',
            'model' => 'T490',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Assigned',
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('error', 'Cannot delete employee because they have assigned products.');
        $this->assertDatabaseHas('employees', ['id' => $employee->id]);
    }

    public function test_can_store_product_with_custom_fields(): void
    {
        $customFields = [
            'company' => 'Google',
            'seats' => '50',
            'min_qty' => '5',
            'product_key' => 'AAAA-BBBB-CCCC-DDDD',
            'manufacturer' => 'Microsoft',
            'licensed_to' => 'DeepMind Team',
            'licensed_to_email' => 'team@deepmind.com',
            'reassignable' => 'Yes',
            'supplier' => 'Direct License Store',
            'order_number' => 'ORD-987654',
            'expiration_date' => '2030-12-31',
            'termination_date' => '2030-12-31',
            'purchase_order_number' => 'PO-123',
            'depreciation' => 'Straight Line',
            'maintained' => 'Yes',
        ];

        $response = $this->actingAs($this->user)->post(route('products.store'), [
            'name' => 'JetBrains All Products Pack',
            'brand' => 'JetBrains',
            'model' => 'Suite v2026',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'status' => 'Available',
            'custom_fields' => $customFields,
        ]);

        $response->assertRedirect(route('products.index'));
        
        $product = Product::where('name', 'JetBrains All Products Pack')->firstOrFail();
        $this->assertEquals($customFields, $product->custom_fields);
    }

    public function test_employee_cannot_assign_product_when_stock_reaches_safety_stock(): void
    {
        $employeeUser = User::factory()->create(['role' => 'employee']);

        $product = Product::create([
            'product_code' => 'LT0002',
            'name' => 'ThinkPad T14',
            'brand' => 'Lenovo',
            'model' => 'T14',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Available',
            'safety_stock' => 10,
            'reorder_level' => 40,
        ]);

        $employee = Employee::create([
            'employee_id' => 'EMP-999',
            'name' => 'Jane Smith',
            'department' => 'HR',
            'designation' => 'Recruiter',
            'email' => 'jane@example.com',
        ]);

        $response = $this->actingAs($employeeUser)->patch(route('products.assign', $product), [
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertNull($product->fresh()->employee_id);
    }

    public function test_admin_can_assign_product_when_stock_reaches_safety_stock(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $product = Product::create([
            'product_code' => 'LT0003',
            'name' => 'ThinkPad T14s',
            'brand' => 'Lenovo',
            'model' => 'T14s',
            'warehouse_id' => $this->warehouse->id,
            'category_id' => $this->category->id,
            'item_type_id' => $this->itemType->id,
            'created_by' => $this->user->id,
            'status' => 'Available',
            'safety_stock' => 10,
            'reorder_level' => 40,
        ]);

        $employee = Employee::create([
            'employee_id' => 'EMP-888',
            'name' => 'Bob Johnson',
            'department' => 'Sales',
            'designation' => 'Agent',
            'email' => 'bob@example.com',
        ]);

        $response = $this->actingAs($adminUser)->patch(route('products.assign', $product), [
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertEquals($employee->id, $product->fresh()->employee_id);
    }
}
