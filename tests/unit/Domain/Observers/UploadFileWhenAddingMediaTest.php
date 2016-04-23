<?php

use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;
use LaravelItalia\Domain\Observers\UploadFileWhenAddingMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileWhenAddingMediaTest extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Media
     */
    private $mediaMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Request
     */
    private $requestMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|UploadedFile
     */
    private $uploadedFileMock;

    public function setUp()
    {
        $this->mediaMock = $this->getMock(Media::class);
        $this->requestMock = $this->getMock(Request::class);
        $this->uploadedFileMock = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();

        parent::setUp();
    }

    public function testUpload()
    {
        $this->uploadedFileMock->expects($this->any())
            ->method('getClientOriginalName')
            ->willReturn('original_name');

        $this->uploadedFileMock->expects($this->once())
            ->method('getRealPath')
            ->willReturn(tempnam('tmp', 'test'));

        $this->requestMock->expects($this->once())
            ->method('file')
            ->willReturn($this->uploadedFileMock);

        \Storage::shouldReceive('put')->once();

        $mediaUploader = new UploadFileWhenAddingMedia($this->requestMock);
        $mediaUploader->creating($this->mediaMock);
    }
}
