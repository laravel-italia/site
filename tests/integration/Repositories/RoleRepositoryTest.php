<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\RoleRepository;

class RoleRepositoryTest extends TestCase
{
    use DatabaseMigrations;

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

    private function saveTestRole()
    {
        $role = new \LaravelItalia\Domain\Role();
        $role->name = 'administrator';

        $role->save();
    }
}
