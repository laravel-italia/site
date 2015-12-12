<?php

use Illuminate\Http\Request;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Observers\MediaUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaUploaderTest extends TestCase
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
        $this->uploadedFileMock->expects($this->once())
            ->method('getClientOriginalName')
            ->willReturn('original_name');

        $this->uploadedFileMock->expects($this->once())
            ->method('getClientOriginalExtension')
            ->willReturn('.jpg');

        $this->uploadedFileMock->expects($this->once())
            ->method('getRealPath')
            ->willReturn(tempnam('tmp', 'test'));

        $this->requestMock->expects($this->once())
            ->method('file')
            ->willReturn($this->uploadedFileMock);

        $expectedFileName = time().'original_name.jpg';

        $this->mediaMock->expects($this->once())
            ->method('setUrl')
            ->with($this->equalTo($expectedFileName));

        \Storage::shouldReceive('put')->once();

        $mediaUploader = new MediaUploader($this->requestMock);
        $mediaUploader->creating($this->mediaMock);
    }
}
