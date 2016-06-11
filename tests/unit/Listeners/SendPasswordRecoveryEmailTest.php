<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Listeners\SendPasswordRecoveryEmail;

/**
 * Class SendPasswordRecoveryEmailTest.
 */
class SendPasswordRecoveryEmailTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserHasRecoveredPassword
     */
    private $event;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $user;

    /**
     * @var SendPasswordRecoveryEmail
     */
    private $listener;

    public function setUp()
    {
        $this->event = $this->getMockBuilder(UserHasRecoveredPassword::class)->disableOriginalConstructor()->getMock();
        $this->user = $this->createMock(User::class);
        $this->listener = new SendPasswordRecoveryEmail();

        parent::setUp();
    }

    public function testSendWithNormalUser()
    {
        $this->event->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->user->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn(null);

        $this->event->expects($this->once())
            ->method('getToken')
            ->willReturn('test_token');

        \Mail::shouldReceive('send')->once();

        $this->listener->handle($this->event);
    }

    public function testNothingHappensWithSocialNetworkUser()
    {
        $this->event->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->user->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn('facebook');

        $this->event->expects($this->never())
            ->method('getToken');

        \Mail::shouldReceive('send')->never();

        $this->listener->handle($this->event);
    }
}
