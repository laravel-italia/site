<?php

use LaravelItalia\Entities\Series;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\SeriesRepository;

class SeriesRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var SeriesRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new SeriesRepository();
        parent::setUp();
    }

    public function testCanSave()
    {
        $this->repository->save($this->prepareTestSeries());

        $this->seeInDatabase('series', [
            'title' => 'Title',
            'slug' => 'title'
        ]);
    }

    public function testCanFindBySlug()
    {
        $this->saveTestSeries();

        $existingSeries = $this->repository->findBySlug('title');
        $notExistingSeries = $this->repository->findBySlug('i-did-it-for-teh-lulz');
        $notExistingSeries2 = $this->repository->findBySlug('title', true);

        $this->assertNotNull($existingSeries);
        $this->assertNull($notExistingSeries);
    }

    public function testCanGetAll()
    {
        $this->assertEmpty($this->repository->getAll());

        $this->saveTestSeries();
        $this->saveTestSeries(true);

        $this->assertCount(2, $this->repository->getAll());
        $this->assertCount(1, $this->repository->getAll(true));
    }

    public function testCanDelete()
    {
        $series = $this->saveTestSeries();

        $this->repository->delete($series);

        $this->dontSeeInDatabase('series', [
            'title' => 'Title',
            'slug' => 'title'
        ]);
    }

    private function prepareTestSeries($published = false)
    {
        $series = new Series;

        $series->title = 'Title';
        $series->slug = 'title';

        $series->is_published = $published;
        $series->is_completed = true;

        return $series;
    }

    private function saveTestSeries($published = false)
    {
        $testSeries = $this->prepareTestSeries($published);
        $testSeries->save();
        return $testSeries;
    }
}