<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\WordCount;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class WordCountTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class WordCountTest extends Unit
{
    /**
     * @dataProvider wordCountValidationData
     */
    public function testWordCountValidation($min, $max, $fileContent, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        vfsStream::newFile('myfile.txt')
            ->withContent($fileContent)
            ->at($root);

        $validator = new WordCount($min, $max);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function wordCountValidationData()
    {
        return [
            0 => [
                '1',                              // Minimum size
                '5',                              // Maximum size
                'test',                           // File content
                vfsStream::url('tmp/myfile.txt'), // Value to test
                true                              // Expected result of validation
            ],
            1 => [
                '1',
                '5',
                '',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            2 => [
                '1',
                '5',
                'test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            3 => [
                '1',
                '5',
                'test test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            4 => [
                null,
                '5',
                '',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            5 => [
                null,
                '5',
                'test test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            6 => [
                '1',
                null,
                'test',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            7 => [
                '1',
                null,
                '',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            8 => [
                '1',
                null,
                'test test test test test test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            9 => [
                null,
                null,
                '',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            10 => [
                null,
                null,
                'test test test test test test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                true
            ]
        ];
    }

    /**
     * @dataProvider wordCountValidationDataWithoutParam
     */
    public function testWordCountValidationWithoutParam($fileContent, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        vfsStream::newFile('myfile.txt')
            ->withContent($fileContent)
            ->at($root);

        $validator = new WordCount();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function wordCountValidationDataWithoutParam()
    {
        return [
            0 => [
                '',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            1 => [
                'test test test test test test test test test test',
                vfsStream::url('tmp/myfile.txt'),
                true
            ]
        ];
    }
}
