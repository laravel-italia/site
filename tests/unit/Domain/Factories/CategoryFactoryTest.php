<?php

use LaravelItalia\Domain\Category;
use LaravelItalia\Domain\Factories\CategoryFactory;

class CategoryFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Category in the right way.
     */
    public function testCanCreateCategory()
    {
        $category = CategoryFactory::createCategory('Test Category');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals('test-category', $category->slug);
    }
}
