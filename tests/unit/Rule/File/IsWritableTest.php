<?php

namespace Tests\ObjectivePHP\Validation\Rule\File;

use Codeception\Test\Unit;
use ObjectivePHP\Validation\Rule\File\IsWritable;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Class IsWritableTest
 *
 * @package Tests\ObjectivePHP\Validation\Rule\File
 */
class IsWritableTest extends Unit
{
    /**
     * @dataProvider isWritableValidationData
     */
    public function testIsWritableValidation($parentRights, $isDirectory, $rights, $value, $expected)
    {
        vfsStreamWrapper::register();
        $root = vfsStream::newDirectory('tmp', 0777);
        vfsStreamWrapper::setRoot($root);

        // If the parent (here $root) isn't executable, children (here $dir or $file) isn't writable
        // I forced children rights to 0000 because vfsStream doesn't manage this PHP behaviour
        if (in_array($parentRights, [0000, 0222, 0444, 0666])) {
            $rights = 0000;
        }

        if ($isDirectory) {
            $dir = vfsStream::newDirectory('dir', $rights);
            $root->addChild($dir);
        } else {
            $file = vfsStream::newFile('file.txt', $rights);
            $root->addChild($file);
        }

        // Change the parent directory rights
        $root->chmod($parentRights);

        $validator = new IsWritable();
        
        $this->assertEquals($expected, $validator->validate($value));
    }

    public function isWritableValidationData()
    {
        return [
            0 => [
                0777,                           // Parent directory rights
                false,                          // Is directory
                0000,                           // Rights
                vfsStream::url('tmp/file.txt'), // Value to test
                false                           // Expected result of validation
            ],
            1 => [
                0777,
                true,
                0000,
                vfsStream::url('tmp/dir'),
                false
            ],
            2 => [
                0777,
                false,
                0111,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            3 => [
                0777,
                true,
                0111,
                vfsStream::url('tmp/dir'),
                false
            ],
            4 => [
                0777,
                false,
                0222,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            5 => [
                0777,
                true,
                0222,
                vfsStream::url('tmp/dir'),
                true
            ],
            6 => [
                0777,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            7 => [
                0777,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                true
            ],
            8 => [
                0777,
                false,
                0444,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            9 => [
                0777,
                true,
                0444,
                vfsStream::url('tmp/dir'),
                false
            ],
            10 => [
                0777,
                false,
                0555,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            11 => [
                0777,
                true,
                0555,
                vfsStream::url('tmp/dir'),
                false
            ],
            12 => [
                0777,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            13 => [
                0777,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                true
            ],
            14 => [
                0777,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            15 => [
                0777,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                true
            ],
            16 => [
                0777,
                false,
                0222,
                vfsStream::url('fileNotExists.txt'),
                false
            ],
            17 => [
                0777,
                true,
                0222,
                vfsStream::url('dirNotExists'),
                false
            ],
            18 => [
                0666, // Parent rights 0666
                true,
                0222,
                vfsStream::url('tmp/dir'),
                false
            ],
            19 => [
                0666,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            20 => [
                0666,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                false
            ],
            21 => [
                0666,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            22 => [
                0666,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                false
            ],
            23 => [
                0666,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            24 => [
                0666,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                false
            ],
            25 => [
                0555, // Parent rights 0555
                true,
                0222,
                vfsStream::url('tmp/dir'),
                true
            ],
            26 => [
                0555,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            27 => [
                0555,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                true
            ],
            28 => [
                0555,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            29 => [
                0555,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                true
            ],
            30 => [
                0555,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            31 => [
                0555,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                true
            ],
            32 => [
                0444, // Parent rights 0444
                true,
                0222,
                vfsStream::url('tmp/dir'),
                false
            ],
            33 => [
                0444,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            34 => [
                0444,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                false
            ],
            35 => [
                0444,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            36 => [
                0444,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                false
            ],
            37 => [
                0444,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            38 => [
                0444,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                false
            ],
            39 => [
                0333, // Parent rights 0333
                true,
                0222,
                vfsStream::url('tmp/dir'),
                true
            ],
            40 => [
                0333,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            41 => [
                0333,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                true
            ],
            42 => [
                0333,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            43 => [
                0333,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                true
            ],
            44 => [
                0333,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            45 => [
                0333,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                true
            ],
            46 => [
                0222, // Parent rights 0222
                true,
                0222,
                vfsStream::url('tmp/dir'),
                false
            ],
            47 => [
                0222,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            48 => [
                0222,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                false
            ],
            49 => [
                0222,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            50 => [
                0222,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                false
            ],
            51 => [
                0222,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            52 => [
                0222,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                false
            ],
            53 => [
                0111, // Parent rights 0111
                true,
                0222,
                vfsStream::url('tmp/dir'),
                true
            ],
            54 => [
                0111,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            55 => [
                0111,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                true
            ],
            56 => [
                0111,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            57 => [
                0111,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                true
            ],
            58 => [
                0111,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                true
            ],
            59 => [
                0111,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                true
            ],
            60 => [
                0000, // Parent rights 0000
                true,
                0222,
                vfsStream::url('tmp/dir'),
                false
            ],
            61 => [
                0000,
                false,
                0333,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            62 => [
                0000,
                true,
                0333,
                vfsStream::url('tmp/dir'),
                false
            ],
            63 => [
                0000,
                false,
                0666,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            64 => [
                0000,
                true,
                0666,
                vfsStream::url('tmp/dir'),
                false
            ],
            65 => [
                0000,
                false,
                0777,
                vfsStream::url('tmp/file.txt'),
                false
            ],
            66 => [
                0000,
                true,
                0777,
                vfsStream::url('tmp/dir'),
                false
            ]
        ];
    }
}
