<?php

use LaravelItalia\Entities\Factories\CategoryFactory;

class CategoryFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Category in the right way.
     *
     * @return void
     */
    public function testCanCreateCategory()
    {
        $category = CategoryFactory::createCategory('Test Category');

        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals('test-category', $category->slug);
    }
}
