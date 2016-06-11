<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Domain\Repositories\CategoryRepository;
use LaravelItalia\Domain\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $repository = new CategoryRepository();

        $repository->save(Category::createFromName('Package'));
        $repository->save(Category::createFromName('Tutorial'));
        $repository->save(Category::createFromName('News'));
        $repository->save(Category::createFromName('Interviste'));
        $repository->save(Category::createFromName('Tips'));
        $repository->save(Category::createFromName('Risorse'));

        Model::reguard();
    }
}
