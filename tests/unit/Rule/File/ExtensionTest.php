<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\Extension;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class ExtensionTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class ExtensionTest extends Unit
{
    /**
     * @dataProvider extensionValidationData
     */
    public function testExtensionValidation($extensions, $case, $filename, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        $file = vfsStream::newFile($filename);
        $root->addChild($file);

        $validator = new Extension($extensions, $case);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function extensionValidationData()
    {
        return [
            0 => [
                [
                    'txt'
                ],                                // Extensions to check
                false,                            // Is case sensitive
                'myfile.txt',                     // File name
                vfsStream::url('tmp/myfile.txt'), // Value to test
                true                              // Expected result of validation
            ],
            1 => [
                [
                    'TXT'
                ],
                false,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            2 => [
                [
                    'txt'
                ],
                false,
                'myfile.TXT',
                vfsStream::url('tmp/myfile.TXT'),
                true
            ],
            3 => [
                [
                    'TXT'
                ],
                false,
                'myfile.TXT',
                vfsStream::url('tmp/myfile.TXT'),
                true
            ],
            4 => [
                [
                    'txt'
                ],
                true,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            5 => [
                [
                    'TXT'
                ],
                true,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            6 => [
                [
                    'txt'
                ],
                true,
                'myfile.TXT',
                vfsStream::url('tmp/myfile.TXT'),
                false
            ],
            7 => [
                [
                    'TXT'
                ],
                true,
                'myfile.TXT',
                vfsStream::url('tmp/myfile.TXT'),
                true
            ],
            8 => [
                [
                    'txt',
                    'doc',
                    'docx'
                ],
                false,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            9 => [
                [
                    'txt',
                    'TXT',
                    'doc',
                    'docx'
                ],
                true,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                true
            ],
            10 => [
                [
                    'TXT',
                    'doc',
                    'docx'
                ],
                true,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            11 => [
                [],
                false,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            12 => [
                [],
                true,
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                false
            ]
        ];
    }

    /**
     * @dataProvider extensionValidationDataWithoutParam
     */
    public function testExtensionValidationWithoutParam($filename, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);
        $file = vfsStream::newFile($filename);
        $root->addChild($file);

        $validator = new Extension();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function extensionValidationDataWithoutParam()
    {
        return [
            0 => [
                'myfile.txt',
                vfsStream::url('tmp/myfile.txt'),
                false
            ],
            0 => [
                'myfile.TXT',
                vfsStream::url('tmp/myfile.TXT'),
                false
            ]
        ];
    }
}
