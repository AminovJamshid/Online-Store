<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $categoryName = 'Electronics';
        $category = Category::factory()->create([
            'name' => $categoryName,
        ]);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($categoryName, $category->name);
    }

    public function test_category_can_have_products()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->products->contains($product));
        $this->assertEquals(1, $category->products->count());
    }

    public function test_category_can_have_subcategories()
    {
        $parentCategory = Category::factory()->create(['name'=> 'Telefonlar']); // id = 1
        $subCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

        $this->assertTrue($parentCategory->subcategories->contains($subCategory));
        $this->assertEquals(1, $parentCategory->subcategories->count());
    }

    public function test_category_name_must_be_unique()
    {
        Category::factory()->create(['name' => 'UniqueName']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // Attempt to create another category with the same name
        Category::factory()->create(['name' => 'UniqueName']);
    }

    public function test_deleting_category_deletes_associated_products()
    {
        $category = Category::factory()->create();
        $product = \App\Models\Product::factory()->create(['category_id' => $category->id]);

        $category->delete();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_category_can_have_parent()
    {
        $parentCategory = Category::factory()->create();
        $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

        $this->assertEquals($parentCategory->id, $childCategory->parent_id);
        $this->assertTrue($parentCategory->subcategories->contains($childCategory));
    }

    public function test_only_fillable_attributes_are_mass_assignable()
    {
        $category = new Category();

        $category->fill([
            'name' => 'Test Category',
            'parent_id' => 1,
            'non_fillable_attribute' => 'Should not be set',
        ]);

        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals(1, $category->parent_id);
        $this->assertArrayNotHasKey('non_fillable_attribute', $category->getAttributes());
    }

    public function test_category_has_default_values()
    {
        $category = new Category();

        $this->assertNull($category->parent_id); // Assuming parent_id defaults to null
    }

    public function test_category_soft_deletes()
    {
        $category = Category::factory()->create();

        $category->delete();

        $this->assertSoftDeleted($category);
    }
}
