<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\Count;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class CountTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class CountTest extends Unit
{
    /**
     * @dataProvider countValidationData
     */
    public function testCountValidation($min, $max, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);

        $file1 = vfsStream::newFile('myfile.txt');
        $root->addChild($file1);
        $file2 = vfsStream::newFile('myfile2.txt');
        $root->addChild($file2);
        $file3 = vfsStream::newFile('myfile3.txt');
        $root->addChild($file3);

        $validator = new Count($min, $max);

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function countValidationData()
    {
        return [
            0 => [
                1,    // Min number of files
                2,    // Max number of files
                [],   // Value to test
                false // Expected result of validation
            ],
            1 => [
                1,
                2,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                true
            ],
            2 => [
                1,
                2,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt'),
                    vfsStream::url('tmp/myfile3.txt')
                ],
                false
            ],
            3 => [
                3,
                null,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                false
            ],
            4 => [
                3,
                null,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt'),
                    vfsStream::url('tmp/myfile3.txt')
                ],
                true
            ],
            5 => [
                null,
                1,
                [
                    vfsStream::url('tmp/myfile.txt')
                ],
                true
            ],
            6 => [
                null,
                1,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt')
                ],
                false
            ],
            7 => [
                null,
                null,
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt'),
                    vfsStream::url('tmp/myfile3.txt')
                ],
                true
            ]
        ];
    }

    /**
     * @dataProvider countValidationDataWithoutParam
     */
    public function testCountValidationWithoutParams($value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp');
        vfsStreamWrapper::setRoot($root);

        $file1 = vfsStream::newFile('myfile.txt');
        $root->addChild($file1);
        $file2 = vfsStream::newFile('myfile2.txt');
        $root->addChild($file2);
        $file3 = vfsStream::newFile('myfile3.txt');
        $root->addChild($file3);

        $validator = new Count();

        $this->assertEquals($expected, $validator->validate($value));
    }

    public function countValidationDataWithoutParam()
    {
        return [
            0 => [
                [],  // Value to test
                true // Expected result of validation
            ],
            1 => [
                [
                    vfsStream::url('tmp/myfile.txt'),
                ],
                true
            ],
            2 => [
                [
                    vfsStream::url('tmp/myfile.txt'),
                    vfsStream::url('tmp/myfile2.txt'),
                    vfsStream::url('tmp/myfile3.txt')
                ],
                true
            ]
        ];
    }
}
