<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Events\UserHasSignedUp;
use LaravelItalia\Listeners\SendWelcomeEmail;

/**
 * Class SendWelcomeEmailTest.
 */
class SendWelcomeEmailTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserHasSignedUp
     */
    private $event;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $user;

    /**
     * @var SendWelcomeEmail
     */
    private $listener;

    public function setUp()
    {
        $this->event = $this->getMockBuilder(UserHasSignedUp::class)->disableOriginalConstructor()->getMock();
        $this->user = $this->getMock(User::class);
        $this->listener = new SendWelcomeEmail();

        parent::setUp();
    }

    public function testSendWithNormalUser()
    {
        $this->user->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn(null);

        $this->event->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        \Mail::shouldReceive('send')->once();

        $this->listener->handle($this->event);
    }

    public function testNothingHappensWithSocialNetworkUser()
    {
        $this->user->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn('facebook');

        $this->event->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        \Mail::shouldReceive('send')->never();

        $this->listener->handle($this->event);
    }
}
