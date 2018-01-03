<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\Size;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class SizeTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class SizeTest extends Unit
{
    /**
     * @dataProvider sizeValidationData
     */
    public function testSizeValidation($min, $max, $useByteString, $fileSize, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        vfsStream::newFile('myfile.txt')
            ->withContent($fileSize)
            ->at($root);

        $validator = new Size($min, $max, $useByteString);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function sizeValidationData()
    {
        return [
            0 => [
                '1kB',                              // Minimum size
                '10MB',                             // Maximum size
                true,                               // Use byte string
                LargeFileContent::withKilobytes(1), // Size of file to create
                vfsStream::url('tmp/myfile.txt'),   // Value to test
                true                                // Expected result of validation
            ],
            1 => [
                '1kB',
                '10MB',
                true,
                LargeFileContent::withKilobytes(0.9),
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            2 => [
                '1kB',
                '10MB',
                true,
                LargeFileContent::withMegabytes(10),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            3 => [
                '1kB',
                '10MB',
                true,
                LargeFileContent::withMegabytes(11),
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            4 => [
                '1kB',
                '10MB',
                false,
                LargeFileContent::withMegabytes(11),
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            5 => [
                null,
                '10MB',
                true,
                LargeFileContent::withKilobytes(0),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            6 => [
                null,
                '10MB',
                true,
                LargeFileContent::withMegabytes(10),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            7 => [
                null,
                '10MB',
                true,
                LargeFileContent::withMegabytes(11),
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            8 => [
                null,
                null,
                true,
                LargeFileContent::withMegabytes(0),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            9 => [
                null,
                null,
                true,
                LargeFileContent::withGigabytes(10),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            10 => [
                '1kB',
                null,
                true,
                LargeFileContent::withKilobytes(1),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            11 => [
                '1kB',
                null,
                true,
                LargeFileContent::withKilobytes(0.9),
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            12 => [
                '1kB',
                null,
                true,
                LargeFileContent::withGigabytes(10),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            13 => [
                '1',
                '1',
                true,
                LargeFileContent::withKilobytes(0.001),
                vfsStream::url('tmp/myfile.txt'),
                true
            ]
        ];
    }

    /**
     * @dataProvider sizeValidationDataWithoutParam
     */
    public function testSizeValidationWithoutParam($fileSize, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        vfsStream::newFile('myfile.txt')
            ->withContent($fileSize)
            ->at($root);

        $validator = new Size();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function sizeValidationDataWithoutParam()
    {
        return [
            0 => [
                LargeFileContent::withMegabytes(0),
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            1 => [
                LargeFileContent::withGigabytes(10),
                vfsStream::url('tmp/myfile.txt'),
                true
            ]
        ];
    }
}
