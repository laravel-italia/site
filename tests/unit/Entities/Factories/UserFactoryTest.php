<?php

class UserFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a User in the right way.
     *
     * @return void
     */
    public function testCanCreateUser()
    {
        $user = \LaravelItalia\Entities\Factories\UserFactory::createUser('Francesco', 'hey@hellofrancesco.com', '123456');

        $this->assertEquals('Francesco', $user->name);
        $this->assertEquals('hey@hellofrancesco.com', $user->email);
        $this->assertEquals(60, strlen($user->password));
    }
}
