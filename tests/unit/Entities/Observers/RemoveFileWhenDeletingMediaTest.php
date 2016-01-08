<?php

use Illuminate\Http\Request;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Observers\RemoveFileWhenDeletingMedia;

class RemoveFileWhenDeletingMediaTest extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Media
     */
    private $mediaMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Request
     */
    private $requestMock;

    public function setUp()
    {
        $this->mediaMock = $this->getMock(Media::class);
        $this->requestMock = $this->getMock(Request::class);

        parent::setUp();
    }

    public function testRemoval()
    {
        \Storage::shouldReceive('delete')->once();

        $mediaUploader = new RemoveFileWhenDeletingMedia($this->requestMock);
        $mediaUploader->deleting($this->mediaMock);
    }
}
