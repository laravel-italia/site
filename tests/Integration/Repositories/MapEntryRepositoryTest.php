<?php

namespace Tests\Integration\Repositories;

use LaravelItalia\Domain\MapEntry;
use Tests\TestCase;
use LaravelItalia\Domain\Repositories\MapEntryRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Integration\Repositories\Support\EntitiesPreparer;

class MapEntryRepositoryTest extends TestCase
{
    use DatabaseMigrations, EntitiesPreparer;

    /**
     * @var MapEntryRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new MapEntryRepository();
        parent::setUp();
    }

    public function testCanGetPublishedEntries()
    {
        $user = $this->saveTestUser();
        $publishedEntry = $this->prepareTestMapEntry();
        $publishedEntry->confirm();
        $unpublishedEntry = $this->prepareTestMapEntry();

        $publishedEntry->user()->associate($user);
        $unpublishedEntry->user()->associate($user);

        $publishedEntry->save();
        $unpublishedEntry->save();

        $mapEntries = $this->repository->getPublishedEntries(1);

        $this->assertCount(1, $mapEntries);
    }

    public function testCanGetPublishedEntriesWithRegionFilter()
    {
        $user = $this->saveTestUser();
        $mapEntry = $this->prepareTestMapEntry();
        $mapEntry->region = 'Abruzzo';
        $mapEntry->confirm();
        $mapEntry->user()->associate($user);
        $mapEntry->save();

        $this->assertCount(1, $this->repository->getPublishedEntries(1, 'all', 'Abruzzo'));
        $this->assertCount(0, $this->repository->getPublishedEntries(1, 'all', 'Marche'));
    }

    public function testCanGetPublishedEntriesWithTypeFilter()
    {
        $mapEntry = $this->saveTestMapEntry();
        $mapEntry->confirm();
        $mapEntry->save();

        $this->assertCount(1, $this->repository->getPublishedEntries(1, 'company', 'all'));
        $this->assertCount(0, $this->repository->getPublishedEntries(1, 'developer', 'all'));
    }

    public function testCanFindByConfirmationToken()
    {
        $mapEntry = $this->saveTestMapEntry();
        $token = $mapEntry->confirmation_token;

        $result = $this->repository->findByConfirmationToken($token);

        $this->assertEquals($token, $result->confirmation_token);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByConfirmationTokenThrowsException()
    {
        $this->repository->findByConfirmationToken('123456');
    }

    public function testCanSave()
    {
        $mapEntry = $this->prepareTestMapEntry();
        $user = $this->saveTestUser();
        $mapEntry->user()->associate($user);

        $this->repository->save($mapEntry);

        $this->seeInDatabase('map_entries', [
            'name' => 'Map Entry'
        ]);
    }

    private function prepareTestMapEntry()
    {
        return MapEntry::fromRequestDataArray([
            'name' => 'Map Entry',
            'description' => 'Lorem ipsum...',
            'type' => 'company',

            'latitude' => 1.0,
            'longitude' => 1.0,
            'region' => 'Abruzzo',
            'city' => 'Vasto',

            'website_url' => '',
            'github_url' => '',
            'facebook_url' => '',
            'twitter_url' => ''
        ]);
    }

    private function saveTestMapEntry()
    {
        $mapEntry = $this->prepareTestMapEntry();
        $user = $this->saveTestUser();
        $mapEntry->user()->associate($user);
        $mapEntry->save();

        return $mapEntry;
    }
}
