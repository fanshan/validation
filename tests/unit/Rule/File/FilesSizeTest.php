<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\FilesSize;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class FilesSizeTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class FilesSizeTest extends Unit
{
    /**
     * @dataProvider filesSizeValidationData
     */
    public function testFilesSizeValidation($min, $max, $useByteString, $fileParams, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);

        foreach ($fileParams as $filename => $fileSize) {
            vfsStream::newFile($filename)
                ->withContent($fileSize)
                ->at($root);
        }

        $validator = new FilesSize($min, $max, $useByteString);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function filesSizeValidationData()
    {
        return [
            0 => [
                '1kB',  // Minimum size
                '10MB', // Maximum size
                true,   // Use byte string
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0.5),
                    'myfile2.txt' => LargeFileContent::withKilobytes(0.5)
                ],     // Files to create
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],     // Value to test
                true   // Expected result of validation
            ],
            1 => [
                '1kB',
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0.5),
                    'myfile2.txt' => LargeFileContent::withKilobytes(0.4)
                ],
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                false
            ],
            2 => [
                '1kB',
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withMegabytes(1),
                    'myfile2.txt' => LargeFileContent::withMegabytes(9)
                ],
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                true
            ],
            3 => [
                '1kB',
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withMegabytes(1),
                    'myfile2.txt' => LargeFileContent::withMegabytes(10)
                ],
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                false
            ],
            4 => [
                '1kB',
                '10MB',
                false,
                [
                    'myfile.txt'  => LargeFileContent::withMegabytes(1),
                    'myfile2.txt' => LargeFileContent::withMegabytes(10)
                ],
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                false
            ],
            5 => [
                '1kB',
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withMegabytes(1)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            6 => [
                null,
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            7 => [
                null,
                '10MB',
                true,
                [
                    'myfile.txt'  => LargeFileContent::withMegabytes(11)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                false
            ],
            8 => [
                null,
                '10MB',
                true,
                [],
                [],
                true
            ],
            9 => [
                null,
                null,
                true,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            10 => [
                null,
                null,
                true,
                [
                    'myfile.txt'  => LargeFileContent::withGigabytes(10)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            11 => [
                null,
                null,
                true,
                [],
                [],
                true
            ],
            12 => [
                '1kB',
                null,
                true,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                false
            ],
            13 => [
                '1kB',
                null,
                true,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(10)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            14 => [
                '1kB',
                null,
                true,
                [],
                [],
                false
            ],
            15 => [
                '1',
                '1',
                false,
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0.001)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ]
        ];
    }

    /**
     * @dataProvider filesSizeValidationDataWithoutParam
     */
    public function testFilesSizeValidationWithoutParam($fileParams, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);

        foreach ($fileParams as $filename => $fileSize) {
            vfsStream::newFile($filename)
                ->withContent($fileSize)
                ->at($root);
        }

        $validator = new FilesSize();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function filesSizeValidationDataWithoutParam()
    {
        return [
            9 => [
                [
                    'myfile.txt'  => LargeFileContent::withKilobytes(0)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            10 => [
                [
                    'myfile.txt'  => LargeFileContent::withGigabytes(10)
                ],
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            11 => [
                [],
                [],
                true
            ]
        ];
    }
}
