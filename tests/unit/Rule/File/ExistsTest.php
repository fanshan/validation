<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\Exists;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class ExistsTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class ExistsTest extends Unit
{
    /**
     * @dataProvider existsValidationData
     */
    public function testExistsValidation($directories, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);

        $directory = vfsStream::newDirectory('dir');
        $root->addChild($directory);

        $file = vfsStream::newFile('myfile.txt');
        $root->addChild($file);

        $validator = new Exists($directories);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function existsValidationData()
    {
        return [
            0 => [
                [
                    vfsStream::url('tmp')
                ],                                // Directories to check
                vfsStream::url('tmp/myfile.txt'), // Value to test
                true                              // Expected result of validation
            ],
            1 => [
                [
                    vfsStream::url('tmp')
                ],
                vfsStream::url('tmp/myfile.doc'),
                false
            ],
            2 => [
                [],
                vfsStream::url('tmp/myfile.doc'),
                false
            ],
            3 => [
                [],
                vfsStream::url('tmp'),
                true
            ],
            4 => [
                [
                    vfsStream::url('tmp')
                ],
                vfsStream::url('dir'),
                true
            ],
            5 => [
                [
                    vfsStream::url('tmp')
                ],
                vfsStream::url('tmp'),
                false
            ]
        ];
    }
}
