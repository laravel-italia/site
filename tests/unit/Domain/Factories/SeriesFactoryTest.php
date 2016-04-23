<?php

use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Factories\SeriesFactory;

class SeriesFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a Series in the right way.
     */
    public function testCanCreateSeries()
    {
        $series = SeriesFactory::createSeries(
            'Test Series',
            'Description...',
            'Metadesc...'
        );

        $this->assertInstanceOf(Series::class, $series);
        $this->assertEquals('Test Series', $series->title);
    }
}
