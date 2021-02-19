<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Task;
use App\Models\TimeBlock;

use App\Services\CategoryService;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCategory()
    {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $this->assertEquals(1, count($categories));
        $this->assertEquals('Foo', $categories[0]->name);
        
        $this->assertEquals(1, count($subcategories));
        $this->assertEquals('-', $subcategories[0]->name);
        $this->assertEquals(1, $subcategories[0]->is_default);
        $this->assertEquals($categories[0]->id, $subcategories[0]->category_id);
    }

    public function testCreateCategoryNameAlreadyExistsForCurrentUser()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(
                ['user_id' => $user->id, 'name' => 'Foo']);
        $this->expectException(\App\Exceptions\CategoryNameAlreadyExistsException::class);
        CategoryService::createCategory($user->id, 'Foo', 10);
    }

    public function testCreateCategoryNameAlreadyExistsForOtherUser()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(
                ['user_id' => $user->id, 'name' => 'Foo']);
        CategoryService::createCategory(1 + $user->id, 'Foo', 10);
        $categories = Category::all();
        $this->assertEquals(2, count($categories));
        $this->assertEquals('Foo', $categories[0]->name);
        $this->assertEquals('Foo', $categories[1]->name);
    }
    
    public function testDeleteCategory() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $this->assertEquals(1, count($categories));
        $this->assertEquals(1, count($subcategories));
        CategoryService::deleteCategory($categories[0]);
        $categories2 = Category::all();
        $subcategories2 = Subcategory::all();
        $this->assertEquals(0, count($categories2));
        $this->assertEquals(0, count($subcategories2));
    }

    public function testDeleteCategoryHasChildTimeBlocks() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        TimeBlock::factory()->create([
            'user_id' => $user->id, 'category_id' => $categories[0]->id]);
        $this->expectException(
                \App\Exceptions\RemovingCategoryHasChildTimeBlocksException::class);
        CategoryService::deleteCategory($categories[0]);
    }

    public function testDeleteCategoryHasChildSubcategories() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        Subcategory::factory()->create([
            'user_id' => $user->id, 'category_id' => $categories[0]->id]);
        $this->expectException(
                \App\Exceptions\RemovingCategoryHasChildSubcategoriesException::class);
        CategoryService::deleteCategory($categories[0]);
    }

    public function testDeleteCategoryHasChildTasks() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        Task::factory()->create([
            'user_id' => $user->id, 'subcategory_id' => $categories[0]->subcategories[0]->id]);
        $this->expectException(
                \App\Exceptions\RemovingCategoryHasChildTasksException::class);
        CategoryService::deleteCategory($categories[0]);
    }
    
    public function testCheckCategorySum() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 20);
        CategoryService::createCategory($user->id, 'Foo2', 80);
        $this->assertTrue(CategoryService::checkCategorySum($user->id));
    }
    
    public function testCheckCategorySumLessThan100() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 20);
        CategoryService::createCategory($user->id, 'Foo2', 70);
        $this->assertFalse(CategoryService::checkCategorySum($user->id));
    }

    public function testCheckCategorySumGreaterThan100() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 20);
        CategoryService::createCategory($user->id, 'Foo2', 40);
        CategoryService::createCategory($user->id, 'Foo3', 50);
        $this->assertFalse(CategoryService::checkCategorySum($user->id));
    }

    public function testCheckCategoryExistsTrue() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 20);
        $this->assertTrue(CategoryService::checkCategoryExists($user->id));
    }
    
    public function testCheckCategoryExistsFalse() {
        $user = User::factory()->create();
        $this->assertFalse(CategoryService::checkCategoryExists($user->id));
    }
    
}
