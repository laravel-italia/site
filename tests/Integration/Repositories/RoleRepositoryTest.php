<?php

namespace Tests\Integration\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\RoleRepository;
use Tests\Integration\Repositories\Support\EntitiesPreparer;

class RoleRepositoryTest extends TestCase
{
    use DatabaseMigrations, EntitiesPreparer;

    /**
     * @var RoleRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new RoleRepository();
        parent::setUp();
    }

    public function testCanFindByName()
    {
        $this->saveTestRole();

        $existingRole = $this->repository->findByName('administrator');

        $this->assertEquals('administrator', $existingRole->name);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByNameThrowsException()
    {
        $this->repository->findByName('king');
    }
}
