<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\InternalPHP;

use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * This test class of SplFileInfo is provided for explicitly describe the comportment of SplFileInfo.
 *
 * Abstract:
 *
 * To resolve:
 * - Internal path is recorded as is, an internal realpath function-like but with no symlink resolve
 * should be implemented for path recording
 * - getLinkTarget should return link path for symlink and for hardlink
 * - getRealPath should return realpath for symlink and for hardlink
 * - php cache some information about files, each time we've got some information clearstatcache function should
 * be call for be sure to get real time information
 *
 * Class SplFileInfoTest
 *
 * @internal
 */
class SplFileInfoTest extends TestCase
{
    /** @var string */
    private $filePath;
    /** @var string */
    private $dirPath;
    /** @var string */
    private $symlinkPath;
    /** @var string */
    private $hardlinkPath;
    /** @var string */
    private $symlinkDirPath;

    /** @var SplFileInfo */
    private $file;
    /** @var SplFileInfo */
    private $dir;
    /** @var SplFileInfo */
    private $symlink;
    /** @var SplFileInfo */
    private $hardlink;
    /** @var SplFileInfo */
    private $symlinkDir;

    protected function setUp(): void
    {
        if ('Linux' !== PHP_OS) {
            exit('This tests needs OS interaction. For now, they only designed for linux');
        }

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'rm -Rf *',
            \sprintf('echo "%s" > file.txt', \str_repeat('0123456789', 50)),
            'ln file.txt hardlink.hl',
            'ln -s file.txt symlink.sl',
            'ln -s . symlink.directory',
        ]));

        parent::setUp();

        $this->dirPath = __DIR__.'/../../var/../var/internal_php';
        $this->filePath = $this->dirPath.'/file.txt';
        $this->symlinkPath = $this->dirPath.'/symlink.sl';
        $this->hardlinkPath = $this->dirPath.'/hardlink.hl';
        $this->symlinkDirPath = $this->dirPath.'/symlink.directory';

        $this->dir = new SplFileInfo($this->dirPath);
        $this->file = new SplFileInfo($this->filePath);
        $this->symlink = new SplFileInfo($this->symlinkPath);
        $this->hardlink = new SplFileInfo($this->hardlinkPath);
        $this->symlinkDir = new SplFileInfo($this->symlinkDirPath);
    }

    protected function tearDown(): void
    {
        if ('Linux' !== PHP_OS) {
            exit('This tests needs OS interaction. For now, they only designed for linux');
        }

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'rm -Rf *',
            'echo "*\n!.gitignore" > .gitignore',
        ]));

        parent::tearDown();
    }

    /**
     * __toString return the path filled in constructor.
     */
    public function testToString(): void
    {
        static::assertEquals($this->dirPath, (string) $this->dir);
        static::assertEquals($this->filePath, (string) $this->file);
        static::assertEquals($this->symlinkPath, (string) $this->symlink);
        static::assertEquals($this->hardlinkPath, (string) $this->hardlink);
    }

    /**
     * getPath return dir path that contain the file | So name should be getDirectoryContainerPath or a something like.
     */
    public function testGetPath(): void
    {
        static::assertEquals(\dirname($this->dirPath), $this->dir->getPath());
        static::assertEquals(\dirname($this->filePath), $this->file->getPath());
        static::assertEquals(\dirname($this->symlinkPath), $this->symlink->getPath());
        static::assertEquals(\dirname($this->hardlinkPath), $this->hardlink->getPath());
    }

    /**
     * getRealPath return the full absolute Path with links resolution for symlinks, not for hard.
     */
    public function testGetRealPath(): void
    {
        static::assertEquals(\realpath($this->dirPath), $this->dir->getRealPath());
        static::assertEquals(\realpath($this->filePath), $this->file->getRealPath());
        static::assertEquals(\realpath($this->filePath), $this->symlink->getRealPath());

        static::assertNotEquals(\realpath($this->filePath), $this->hardlink->getRealPath());
    }

    /**
     * getLinkTarget works only with symlink, in other case it is throw an exception.
     */
    public function testGetLinkTarget(): void
    {
        $errors = [];

        try {
            $this->dir->getLinkTarget();
        } catch (\Throwable $e) {
            $errors[] = $e;
        }

        try {
            $this->file->getLinkTarget();
        } catch (\Throwable $e) {
            $errors[] = $e;
        }

        static::assertIsString($this->symlink->getLinkTarget());

        try {
            $this->hardlink->getLinkTarget();
        } catch (\Throwable $e) {
            $errors[] = $e;
        }

        static::assertCount(3, $errors);
    }

    /**
     * Return the last component like basename(path, null) does.
     */
    public function testGetFilename(): void
    {
        static::assertEquals(\basename($this->dirPath), $this->dir->getFilename());
        static::assertEquals(\basename($this->filePath), $this->file->getFilename());
        static::assertEquals(\basename($this->symlinkPath), $this->symlink->getFilename());
        static::assertEquals(\basename($this->hardlinkPath), $this->hardlink->getFilename());
    }

    /**
     * Get type is not very useful but here is... note that hard link return file.
     */
    public function testGetType(): void
    {
        static::assertEquals('dir', $this->dir->getType());
        static::assertEquals('file', $this->file->getType());
        static::assertEquals('link', $this->symlink->getType());
        static::assertEquals('file', $this->hardlink->getType());
    }

    /**
     * Files, links and hardlinks returns TRUE.
     */
    public function testIsFile(): void
    {
        static::assertFalse($this->dir->isFile());

        static::assertTrue($this->file->isFile());
        static::assertTrue($this->symlink->isFile());
        static::assertTrue($this->hardlink->isFile());
    }

    /**
     * Return TRUE if mode authorize reading , for symlink it the right of the pointed file.
     */
    public function testIsReadable(): void
    {
        static::assertTrue($this->dir->isReadable());
        static::assertTrue($this->file->isReadable());
        static::assertTrue($this->symlink->isReadable());
        static::assertTrue($this->hardlink->isReadable());

        \chmod($this->file, 0000);

        static::assertFalse($this->file->isReadable());
        static::assertFalse($this->symlink->isReadable());
        static::assertFalse($this->hardlink->isReadable());
    }

    /**
     * getPathName return path like it was passed in constructor.
     */
    public function testGetPathname(): void
    {
        static::assertEquals($this->dirPath, $this->dir->getPathname());
        static::assertEquals($this->filePath, $this->file->getPathname());
        static::assertEquals($this->symlinkPath, $this->symlink->getPathname());
        static::assertEquals($this->hardlinkPath, $this->hardlink->getPathname());
    }

    /**
     * getInode return the ID node . Same Inode is returned for file and hardlink.
     */
    public function testGetInode(): void
    {
        static::assertIsInt($this->dir->getInode());
        static::assertIsInt($this->file->getInode());
        static::assertIsInt($this->symlink->getInode());
        static::assertIsInt($this->hardlink->getInode());
        static::assertEquals($this->file->getInode(), $this->hardlink->getInode());
    }

    /**
     * getSize return the file size, for symlink it is the size of the target
     * If file change after the first call, getSize return the previous value! Be careful about it!
     * The same behaviour is not true for symlink and hardlink that always resolve the real size
     * It return an RuntimeException if file not exist anymore.
     */
    public function testGetSize(): void
    {
        $originalFileSize = $this->file->getSize();
        $originalSymlinkSize = $this->file->getSize();
        $originalHardLinkSize = $this->file->getSize();
        static::assertEquals($originalFileSize, $originalSymlinkSize);
        static::assertEquals($originalFileSize, $originalHardLinkSize);

        \file_put_contents($this->filePath, \str_repeat('0123456789', 50), FILE_APPEND);

        $fileSizeNotUpdated = $this->file->getSize();
        // We can see than file size is not updated! ...
        static::assertEquals($originalFileSize, $fileSizeNotUpdated);

        // ... But we've got the updated size for hardlink and symlink :-/ !
        $symlinkSizeUpdated = $this->symlink->getSize();
        $hardLinkSizeUpdated = $this->hardlink->getSize();
        static::assertNotEquals($originalFileSize, $symlinkSizeUpdated);
        static::assertNotEquals($originalFileSize, $hardLinkSizeUpdated);

        // ... But if we clearstatcache it is now good ...
        \clearstatcache(true, $this->filePath);
        $fileSizeUpdated = $this->file->getSize();
        static::assertNotEquals($originalFileSize, $fileSizeUpdated);

        // And what about if file disappear ?
        \unlink($this->filePath);
        static::expectExceptionMessage(\sprintf('SplFileInfo::getSize(): stat failed for %s', $this->filePath));
        $this->file->getSize();
    }

    /**
     * Ok let's try to get file size again but let's try with a modification from outside of the script
     * and check the react
     * Reaction is similar except if file was delete from outside, in this case we get the last cached size!
     * Not what we expect!
     */
    public function testGetSizeOutsideOfTheBox(): void
    {
        $originalFileSize = $this->file->getSize();
        $originalSymlinkSize = $this->file->getSize();
        $originalHardLinkSize = $this->file->getSize();
        static::assertEquals($originalFileSize, $originalSymlinkSize);
        static::assertEquals($originalFileSize, $originalHardLinkSize);

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'echo "0123456789" >> file.txt',
        ]));

        $fileSizeNotUpdated = $this->file->getSize();
        // We can see than file size is not updated! ...
        static::assertEquals($originalFileSize, $fileSizeNotUpdated);

        // ... But we've got the updated size for hardlink and symlink :-/ !
        $symlinkSizeUpdated = $this->symlink->getSize();
        $hardLinkSizeUpdated = $this->hardlink->getSize();
        static::assertNotEquals($originalFileSize, $symlinkSizeUpdated);
        static::assertNotEquals($originalFileSize, $hardLinkSizeUpdated);

        // ... But if we clearstatcache it is now good ...
        \clearstatcache(true, $this->filePath);
        $fileSizeUpdated = $this->file->getSize();
        static::assertNotEquals($originalFileSize, $fileSizeUpdated);

        // And what about if file disappear ?
        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'unlink file.txt',
        ]));

        // Whaou! We get a size for a file that does not exist!
        static::assertIsInt($this->file->getSize());

        // But like expected symlink is resolved and we've got an error
        static::expectExceptionMessage(\sprintf('SplFileInfo::getSize(): stat failed for %s', $this->symlink));
        $this->symlink->getSize();
    }

    /**
     * Get the last access to file
     * Access time directory never change.
     */
    public function testGetATime(): void
    {
        $dirATime = $this->dir->getATime();
        $fileATime = $this->file->getATime();
        $symlinkATime = $this->symlink->getATime();
        $hardlinkATime = $this->hardlink->getATime();

        \usleep(1250000);

        \file_get_contents($this->filePath);

        $dirATime2 = $this->dir->getATime();
        $fileATime2 = $this->file->getATime();
        $symlinkATime2 = $this->symlink->getATime();
        $hardlinkATime2 = $this->hardlink->getATime();

        static::assertEquals($dirATime, $dirATime2);
        static::assertNotEquals($fileATime, $fileATime2);
        static::assertNotEquals($symlinkATime, $symlinkATime2);
        static::assertNotEquals($hardlinkATime, $hardlinkATime2);
    }

    /**
     * Should get the Change time. Change time is about permission change and/or content modification too.
     */
    public function testGetCTime(): void
    {
        $dirCTime = $this->dir->getCTime();
        $fileCTime = $this->file->getCTime();
        $symlinkCTime = $this->symlink->getCTime();
        $hardlinkCTime = $this->hardlink->getCTime();

        \sleep(1);

        \file_get_contents($this->filePath);

        $dirCTime2 = $this->dir->getCTime();
        $fileCTime2 = $this->file->getCTime();
        $symlinkCTime2 = $this->symlink->getCTime();
        $hardlinkCTime2 = $this->hardlink->getCTime();

        static::assertEquals($dirCTime, $dirCTime2);
        static::assertEquals($fileCTime, $fileCTime2);
        static::assertEquals($symlinkCTime, $symlinkCTime2);
        static::assertEquals($hardlinkCTime, $hardlinkCTime2);

        \sleep(1);

        \file_put_contents($this->filePath, 'some data', FILE_APPEND);

        $dirCTime2 = $this->dir->getCTime();
        $fileCTime2 = $this->file->getCTime();
        $symlinkCTime2 = $this->symlink->getCTime();
        $hardlinkCTime2 = $this->hardlink->getCTime();

        static::assertEquals($dirCTime, $dirCTime2);
        static::assertNotEquals($fileCTime, $fileCTime2);
        static::assertNotEquals($symlinkCTime, $symlinkCTime2);
        static::assertNotEquals($hardlinkCTime, $hardlinkCTime2);

        \sleep(1);

        \chmod($this->filePath, 0622);
        $fileCTime3 = $this->file->getCTime();
        static::assertNotEquals($fileCTime2, $fileCTime3);
    }

    /**
     * Should return the modification time (Understand modification as content change only).
     */
    public function testGetMTime(): void
    {
        $dirMTime = $this->dir->getMTime();
        $fileMTime = $this->file->getMTime();
        $symlinkMTime = $this->symlink->getMTime();
        $hardlinkMTime = $this->hardlink->getMTime();

        \sleep(1);

        \file_get_contents($this->filePath);

        $dirMTime2 = $this->dir->getMTime();
        $fileMTime2 = $this->file->getMTime();
        $symlinkMTime2 = $this->symlink->getMTime();
        $hardlinkMTime2 = $this->hardlink->getMTime();

        static::assertEquals($dirMTime, $dirMTime2);
        static::assertEquals($fileMTime, $fileMTime2);
        static::assertEquals($symlinkMTime, $symlinkMTime2);
        static::assertEquals($hardlinkMTime, $hardlinkMTime2);

        \sleep(1);

        \file_put_contents($this->filePath, 'some data', FILE_APPEND);

        $dirMTime2 = $this->dir->getMTime();
        $fileMTime2 = $this->file->getMTime();
        $symlinkMTime2 = $this->symlink->getMTime();
        $hardlinkMTime2 = $this->hardlink->getMTime();

        static::assertEquals($dirMTime, $dirMTime2);
        static::assertNotEquals($fileMTime, $fileMTime2);
        static::assertNotEquals($symlinkMTime, $symlinkMTime2);
        static::assertNotEquals($hardlinkMTime, $hardlinkMTime2);

        \sleep(1);

        \chmod($this->filePath, 0622);
        $fileMTime3 = $this->file->getMTime();
        static::assertEquals($fileMTime2, $fileMTime3);
    }

    /**
     * Let's try again the time function but with some files modification from the outside ot that script
     * As result, we see no side effects, it's like stat was not being cached by PHP.
     */
    public function testGetTimesOutOfTheBox(): void
    {
        $fileATime = $this->file->getATime();
        $symlinkATime = $this->symlink->getATime();
        $hardlinkATime = $this->hardlink->getATime();

        \usleep(1250000);

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'cat file.txt',
        ]));

        static::assertNotEquals($fileATime, $this->file->getATime());
        static::assertNotEquals($symlinkATime, $this->symlink->getATime());
        static::assertNotEquals($hardlinkATime, $this->hardlink->getATime());

        $fileMTime = $this->file->getMTime();
        $symlinkMTime = $this->symlink->getMTime();
        $hardlinkMTime = $this->hardlink->getMTime();

        \usleep(1250000);

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'echo "0123456789" >> file.txt',
        ]));

        static::assertNotEquals($fileMTime, $this->file->getMTime());
        static::assertNotEquals($symlinkMTime, $this->symlink->getMTime());
        static::assertNotEquals($hardlinkMTime, $this->hardlink->getMTime());

        $fileCTime = $this->file->getCTime();
        $symlinkCTime = $this->symlink->getCTime();
        $hardlinkCTime = $this->hardlink->getCTime();

        \usleep(1250000);

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'chmod o-w file.txt',
        ]));

        static::assertNotEquals($fileCTime, $this->file->getCTime());
        static::assertNotEquals($symlinkCTime, $this->symlink->getCTime());
        static::assertNotEquals($hardlinkCTime, $this->hardlink->getCTime());
    }

    /**
     * Get Permission integer mode.
     */
    public function testGetPerms(): void
    {
        $filePerms = $this->file->getPerms();
        $symlinkPerms = $this->symlink->getPerms();
        $hardlinkPerms = $this->hardlink->getPerms();

        \chmod($this->filePath, 0622);

        $filePermsUpdated = $this->file->getPerms();
        $symlinkPermsUpdated = $this->symlink->getPerms();
        $hardlinkPermsUpdated = $this->hardlink->getPerms();

        static::assertNotEquals($filePerms, $filePermsUpdated);
        static::assertNotEquals($symlinkPerms, $symlinkPermsUpdated);
        static::assertNotEquals($hardlinkPerms, $hardlinkPermsUpdated);
    }

    /**
     * Return the last component like basename(path, endStringToRemove) does.
     */
    public function testGetBasename(): void
    {
        static::assertEquals(\basename($this->dirPath), $this->dir->getBasename());
        static::assertEquals(\basename($this->filePath), $this->file->getBasename());
        static::assertEquals(\basename($this->symlinkPath), $this->symlink->getBasename());
        static::assertEquals(\basename($this->hardlinkPath), $this->hardlink->getBasename());
    }

    /**
     * Test if is a directory.
     */
    public function testIsDir(): void
    {
        static::assertTrue($this->dir->isDir());
        static::assertFalse($this->file->isDir());
        static::assertFalse($this->symlink->isDir());
        static::assertFalse($this->hardlink->isDir());
        static::assertTrue($this->symlinkDir->isDir());
    }

    /**
     * Get the owner id.
     */
    public function testGetOwner(): void
    {
        static::assertEquals(\posix_getuid(), $this->dir->getOwner());
        static::assertEquals(\posix_getuid(), $this->file->getOwner());
        static::assertEquals(\posix_getuid(), $this->symlink->getOwner());
        static::assertEquals(\posix_getuid(), $this->hardlink->getOwner());
    }

    public function testGetGroup(): void
    {
        static::assertEquals(\posix_getgid(), $this->dir->getGroup());
        static::assertEquals(\posix_getgid(), $this->file->getGroup());
        static::assertEquals(\posix_getgid(), $this->symlink->getGroup());
        static::assertEquals(\posix_getgid(), $this->hardlink->getGroup());
    }

    public function testIsExecutable(): void
    {
        static::assertTrue($this->dir->isExecutable());
        static::assertFalse($this->file->isExecutable());
        static::assertFalse($this->symlink->isExecutable());
        static::assertFalse($this->hardlink->isExecutable());
        static::assertTrue($this->symlinkDir->isExecutable());

        \chmod($this->filePath, 0777);

        static::assertTrue($this->file->isExecutable());
        static::assertTrue($this->symlink->isExecutable());
        static::assertTrue($this->hardlink->isExecutable());

        \chmod($this->filePath, 0666);

        static::assertFalse($this->file->isExecutable());
        static::assertFalse($this->symlink->isExecutable());
        static::assertFalse($this->hardlink->isExecutable());

        \shell_exec(\implode(' && ', [
            \sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'chmod a+x file.txt',
        ]));

        static::assertTrue($this->file->isExecutable());
        static::assertTrue($this->symlink->isExecutable());
        static::assertTrue($this->hardlink->isExecutable());
    }

    public function testIsWritable(): void
    {
        static::assertTrue($this->dir->isWritable());
        static::assertTrue($this->file->isWritable());
        static::assertTrue($this->symlink->isWritable());
        static::assertTrue($this->hardlink->isWritable());
        static::assertTrue($this->symlinkDir->isWritable());

        \chmod($this->filePath, 0555);

        static::assertFalse($this->file->isWritable());
        static::assertFalse($this->symlink->isWritable());
        static::assertFalse($this->hardlink->isWritable());
    }

    /**
     * return the extension following REGEX: \..+$.
     */
    public function testGetExtension(): void
    {
        static::assertEquals('', $this->dir->getExtension());
        static::assertEquals('txt', $this->file->getExtension());
        static::assertEquals('sl', $this->symlink->getExtension());
        static::assertEquals('hl', $this->hardlink->getExtension());
        static::assertEquals('directory', $this->symlinkDir->getExtension());
    }

    /**
     * return true for symlink but false for hardlink.
     */
    public function testIsLink(): void
    {
        static::assertFalse($this->dir->isLink());
        static::assertFalse($this->file->isLink());
        static::assertTrue($this->symlink->isLink());
        static::assertFalse($this->hardlink->isLink());
        static::assertTrue($this->symlinkDir->isLink());
    }
}
