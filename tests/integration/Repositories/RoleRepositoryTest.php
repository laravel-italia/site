<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\RoleRepository;

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
        $this->prepareTestRoleSeed();

        $existingRole = $this->repository->findByName('administrator');
        $notExistingRole = $this->repository->findByName('editor');

        $this->assertNotNull($existingRole);
        $this->assertNull($notExistingRole);

        $this->assertEquals('administrator', $existingRole->name);
    }

    private function prepareTestRoleSeed()
    {
        $role = new \LaravelItalia\Entities\Role();
        $role->name = 'administrator';

        $role->save();
    }
}
