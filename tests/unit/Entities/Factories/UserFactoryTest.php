<?php

use LaravelItalia\Entities\User;

class UserFactoryTest extends TestCase
{
    /**
     * Test if the factory is able to create a User in the right way.
     */
    public function testCanCreateUser()
    {
        $user = \LaravelItalia\Entities\Factories\UserFactory::createUser('Francesco', 'hey@hellofrancesco.com', '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Francesco', $user->name);
        $this->assertEquals('francesco', $user->slug);
        $this->assertEquals('hey@hellofrancesco.com', $user->email);
        $this->assertEquals(60, strlen($user->password));
        $this->assertEquals(false, $user->is_confirmed);
        $this->assertEquals(40, strlen($user->confirmation_code));
    }

    /**
     * Test if the factory is able to create a User in the right way.
     */
    public function testCanCreateSocialUser()
    {
        $user = \LaravelItalia\Entities\Factories\UserFactory::createUserFromSocialNetwork('Francesco', 'hey@hellofrancesco.com', 'facebook', 'FACEBOOK_ID');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Francesco', $user->name);
        $this->assertEquals('hey@hellofrancesco.com', $user->email);
        $this->assertEquals(0, strlen($user->password));
        $this->assertEquals(true, $user->is_confirmed);
        $this->assertEquals(0, strlen($user->confirmation_code));
        $this->assertEquals('facebook', $user->provider);
        $this->assertEquals('FACEBOOK_ID', $user->provider_id);
    }
}
