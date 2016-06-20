<?php

use LaravelItalia\Domain\Media;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\MediaRepository;
use LaravelItalia\Domain\Observers\UploadFileWhenAddingMedia;
use LaravelItalia\Domain\Observers\RemoveFileWhenDeletingMedia;

class MediaRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var MediaRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new MediaRepository();
        parent::setUp();
    }

    public function testCanGetAll()
    {
        $this->app->bind(UploadFileWhenAddingMedia::class, function () {
            return $this->getMockBuilder(UploadFileWhenAddingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $this->app->bind(RemoveFileWhenDeletingMedia::class, function () {
            return $this->getMockBuilder(RemoveFileWhenDeletingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $emptyMediaResults = $this->repository->getAll(1);

        $this->assertEmpty($emptyMediaResults);

        $this->saveTestMedia();

        $mediaResults = $this->repository->getAll(1);

        $this->assertCount(1, $mediaResults);
    }

    public function testFindById()
    {
        $this->app->bind(UploadFileWhenAddingMedia::class, function () {
            return $this->getMockBuilder(UploadFileWhenAddingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $this->app->bind(RemoveFileWhenDeletingMedia::class, function () {
            return $this->getMockBuilder(RemoveFileWhenDeletingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $expectedMedia = $this->saveTestMedia();

        $media = $this->repository->findById($expectedMedia->id);

        $this->assertEquals($expectedMedia->id, $media->id);
    }

    public function testCanSave()
    {
        $this->app->bind(UploadFileWhenAddingMedia::class, function () {
            return $this->getMockBuilder(UploadFileWhenAddingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $this->app->bind(RemoveFileWhenDeletingMedia::class, function () {
            return $this->getMockBuilder(RemoveFileWhenDeletingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $media = $this->prepareTestMedia();

        $this->repository->save($media);

        $this->seeInDatabase('media', [
            'url' => 'test_url_lmao.jpg',
        ]);
    }

    public function testCanDelete()
    {
        $this->app->bind(UploadFileWhenAddingMedia::class, function () {
            return $this->getMockBuilder(UploadFileWhenAddingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $this->app->bind(RemoveFileWhenDeletingMedia::class, function () {
            return $this->getMockBuilder(RemoveFileWhenDeletingMedia::class)->disableOriginalConstructor()->getMock();
        });

        $media = $this->saveTestMedia();

        $this->seeInDatabase('media', [
            'url' => 'test_url_lmao.jpg',
        ]);

        $this->repository->delete($media);

        $this->dontSeeInDatabase('media', [
            'url' => 'test_url_lmao.jpg',
        ]);
    }

    public function prepareTestMedia()
    {
        $media = new Media();

        $media->url = 'test_url_lmao.jpg';
        $media->user_id = 1;

        return $media;
    }

    public function saveTestMedia()
    {
        $media = $this->prepareTestMedia();
        $media->save();

        return $media;
    }
}
