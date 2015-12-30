<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Entities\Repositories\CategoryRepository;
use LaravelItalia\Entities\Factories\CategoryFactory;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $repository = new CategoryRepository();

        $repository->save(CategoryFactory::createCategory('Package'));
        $repository->save(CategoryFactory::createCategory('Tutorial'));
        $repository->save(CategoryFactory::createCategory('News'));
        $repository->save(CategoryFactory::createCategory('Interviste'));
        $repository->save(CategoryFactory::createCategory('Tips'));
        $repository->save(CategoryFactory::createCategory('Risorse'));

        Model::reguard();
    }
}
