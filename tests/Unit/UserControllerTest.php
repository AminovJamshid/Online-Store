<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created()
    {
        $product = Product::factory()->create([
            'name' => 'Smartphone',
            'price' => 250,
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Smartphone', $product->name);
        $this->assertEquals(250, $product->price);
    }

    public function test_product_belongs_to_category()
    {
        $category = Category::factory()->create(['name' => 'Electronics']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertEquals($category->id, $product->category_id);
        $this->assertTrue($category->products->contains($product));
    }

    public function test_product_can_have_multiple_attributes()
    {
        $product = Product::factory()->create([
            'name' => 'Laptop',
            'price' => 1500,
            'description' => 'A high-end gaming laptop',
        ]);

        $this->assertEquals('Laptop', $product->name);
        $this->assertEquals(1500, $product->price);
        $this->assertEquals('A high-end gaming laptop', $product->description);
    }

    public function test_product_name_must_be_unique()
    {
        Product::factory()->create(['name' => 'UniqueProduct']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::factory()->create(['name' => 'UniqueProduct']);
    }

    public function test_deleting_product_does_not_affect_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $product->delete();

        $this->assertModelExists($category);
    }

    public function test_only_fillable_attributes_are_mass_assignable()
    {
        $product = new Product();

        $product->fill([
            'name' => 'Test Product',
            'price' => 200,
            'non_fillable_attribute' => 'Should not be set',
        ]);

        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(200, $product->price);
        $this->assertArrayNotHasKey('non_fillable_attribute', $product->getAttributes());
    }

    public function test_product_has_default_values()
    {
        $product = new Product();

        $this->assertNull($product->description);
        $this->assertEquals(0, $product->price);
    }

    public function test_product_soft_deletes()
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertSoftDeleted($product);
    }

    public function test_product_can_be_restored_from_soft_delete()
    {
        $product = Product::factory()->create();
        $product->delete();

        $this->assertSoftDeleted($product);

        $product->restore();
        $this->assertModelExists($product);
    }
}
