<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use LaravelItalia\Domain\User;
use LaravelItalia\Events\EditorHasBeenInvited;
use LaravelItalia\Listeners\SendEditorInvitationEmail;

/**
 * Class SendEditorInvitationEmailTest.
 */
class SendEditorInvitationEmailTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EditorHasBeenInvited
     */
    private $event;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $user;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SendEditorInvitationEmail
     */
    private $listener;

    public function setUp()
    {
        $this->event = $this->getMockBuilder(EditorHasBeenInvited::class)->disableOriginalConstructor()->getMock();
        $this->user = $this->createMock(User::class);
        $this->listener = new SendEditorInvitationEmail();

        parent::setUp();
    }

    public function testSendWithNormalUser()
    {
        $this->event->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        \Mail::shouldReceive('send')->once();

        $this->listener->handle($this->event);
    }
}
