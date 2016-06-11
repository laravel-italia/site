<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Domain\Series;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        Series::createFromTitleAndDescriptionAndMetaDescription('Serie 1', 'Lorem ipsum...', 'Meta lorem ipsum...');
        Series::createFromTitleAndDescriptionAndMetaDescription('Serie 2', 'Lorem ipsum...', 'Meta lorem ipsum...');

        Model::reguard();
    }
}
