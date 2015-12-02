<?php

use LaravelItalia\Entities\Series;
use LaravelItalia\Entities\Factories\SeriesFactory;

class SeriesFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Series in the right way.
     *
     * @return void
     */
    public function testCanCreateSeries()
    {
        $series = SeriesFactory::createSeries(
            'Test Series',
            'Description...',
            'Metadesc...',
            false,
            false
        );

        $this->assertInstanceOf(Series::class, $series);
        $this->assertEquals('Test Series', $series->title);
    }
}
