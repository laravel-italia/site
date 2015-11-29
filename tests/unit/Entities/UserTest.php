<?php

class UserTest extends TestCase
{
    public function testUserConfirmation()
    {
        $user = $this->prepareTestUser(false);

        $user->confirm();

        $this->assertEquals(true, $user->is_confirmed);
    }

    /**
     * @expectedException           \Exception
     * @expectedExceptionMessage    already_confirmed
     */
    public function testUserIsAlreadyConfirmed()
    {
        $user = $this->prepareTestUser(true);

        $user->confirm();
    }

    private function prepareTestUser($isAlreadyConfirmed)
    {
        $user = new \LaravelItalia\Entities\User;

        $user->name = 'Francesco';
        $user->email = 'Malatesta';
        $user->password = '';

        $user->is_confirmed = $isAlreadyConfirmed;
        $user->confirmation_code = 'TESTCODE';

        return $user;
    }
}