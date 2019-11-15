<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\PHPUnitExt;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * @internal
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    use RetryTrait;
    protected const TEMP_DIR = __DIR__.'/../var/tmp';

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        (new TestCase())->cleanUpTmp();
        (new TestCase())->addGitIgnore();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanUpTmp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->cleanUpTmp();
    }

    private function cleanUpTmp(): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::TEMP_DIR, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \SplFileInfo $fileInfo */
        foreach ($files as $fileInfo) {
            $todo = ($fileInfo->isDir() ? 'rmdir' : 'unlink');
            @$todo($fileInfo->getRealPath());
        }
    }

    private function addGitIgnore(): void
    {
        \file_put_contents(self::TEMP_DIR.\DIRECTORY_SEPARATOR.'.gitignore', "*\n!.gitignore\n");
    }
}
