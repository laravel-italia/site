<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Entities\Repositories\SeriesRepository;
use LaravelItalia\Entities\Factories\SeriesFactory;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $repository = new SeriesRepository();

        $repository->save(SeriesFactory::createSeries('Serie 1', 'Lorem ipsum...', 'Meta lorem ipsum...'));
        $repository->save(SeriesFactory::createSeries('Serie 2', 'Lorem ipsum...', 'Meta lorem ipsum...'));
        $repository->save(SeriesFactory::createSeries('Serie 3', 'Lorem ipsum...', 'Meta lorem ipsum...'));
        $repository->save(SeriesFactory::createSeries('Serie 4', 'Lorem ipsum...', 'Meta lorem ipsum...'));

        Model::reguard();
    }
}
