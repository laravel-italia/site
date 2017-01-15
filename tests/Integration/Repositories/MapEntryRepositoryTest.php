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
}
