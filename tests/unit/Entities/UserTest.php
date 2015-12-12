<?php

class UserTest extends TestCase
{
    public function testUserConfirmation()
    {
        $user = $this->prepareTestUser(false);

        $user->confirm();

        $this->assertEquals(true, $user->is_confirmed);
    }

    public function testSetNewPassword()
    {
        $user = $this->prepareTestUser(false);

        $user->setNewPassword('123456');

        $this->assertNotEquals('', $user->password);
        $this->assertTrue(Hash::check(
            '123456',
            $user->password
        ));
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
        $user = new \LaravelItalia\Entities\User();

        $user->name = 'Francesco';
        $user->email = 'Malatesta';
        $user->password = '';

        $user->is_confirmed = $isAlreadyConfirmed;
        $user->confirmation_code = 'TESTCODE';

        return $user;
    }
}
