<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Factories\UserFactory;

class UserFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a User in the right way.
     */
    public function testCanCreateUser()
    {
        $user = UserFactory::createUser('Francesco', 'hey@hellofrancesco.com', '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Francesco', $user->name);
        $this->assertEquals('hey@hellofrancesco.com', $user->email);
        $this->assertEquals(60, strlen($user->password));
        $this->assertEquals(false, $user->is_confirmed);
        $this->assertEquals(40, strlen($user->confirmation_code));
    }
}
