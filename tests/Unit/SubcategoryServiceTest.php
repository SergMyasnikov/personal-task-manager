<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Task;

use App\Services\CategoryService;
use App\Services\SubcategoryService;


class SubcategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteSubcategory() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        $subcategory = Subcategory::factory()->create(
                ['user_id' => $user->id, 'category_id' => $categories[0]->id]);
        $subcategoryId = $subcategory->id;
        $subcategories = Subcategory::all();
        $this->assertEquals(2, count($subcategories));
        SubcategoryService::deleteSubcategory($subcategory);
        $subcategories2 = Subcategory::all();
        $this->assertEquals(1, count($subcategories2));
        $this->assertNotEquals($subcategoryId, $subcategories2[0]->id);
    }
    
    public function testDeleteSubcategoryIsDefault() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $this->expectException(\App\Exceptions\DirectlyRemovingDefaultSubcategoryException::class);
        SubcategoryService::deleteSubcategory($subcategories[0]);
    }
    
    public function testDeleteSubcategoryHasChildTasks() {
        $user = User::factory()->create();
        CategoryService::createCategory($user->id, 'Foo', 10);
        $categories = Category::all();
        $subcategory = Subcategory::factory()->create(
                ['user_id' => $user->id, 'category_id' => $categories[0]->id]);
        $subcategory->id;
        $task = Task::factory()->create(
                ['user_id' => $user->id, 'subcategory_id' => $subcategory->id]);
        $this->expectException(\App\Exceptions\RemovingSubcategoryHasChildTasksException::class);
        SubcategoryService::deleteSubcategory($subcategory);
    }
    
    
}
