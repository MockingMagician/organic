<?php

namespace MockingMagician\Organic\Tests\InternalPHP;

use SplFileInfo;
use PHPUnit\Framework\TestCase;

/**
 * This test class of SplFileInfo is provided for explicitly describe the comportment of SplFileInfo
 *
 * Class SplFileInfoTest
 * @package MockingMagician\Organic\Tests\InternalPHP
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

    /** @var SplFileInfo */
    private $file;
    /** @var SplFileInfo */
    private $dir;
    /** @var SplFileInfo */
    private $symlink;
    /** @var SplFileInfo */
    private $hardlink;

    public function setUp(): void
    {
        if ('Linux' !== PHP_OS) {
            throw new \RuntimeException('This test should be run on Linux only');
        }

        shell_exec(implode(' && ', [
            sprintf('cd %s', __DIR__),
            'cd ../../var/internal_php',
            'rm -Rf *',
            sprintf('echo "%s" > file.txt', str_repeat('0123456789', 50)),
            'ln file.txt hardlink.hl',
            'ln -s file.txt symlink.sl',
        ]));;

        parent::setUp();

        $this->dirPath = __DIR__ . '/../../var/../var/internal_php';
        $this->filePath = $this->dirPath.'/file.txt';
        $this->symlinkPath = $this->dirPath.'/symlink.sl';
        $this->hardlinkPath = $this->dirPath.'/hardlink.hl';

        $this->dir = new SplFileInfo($this->dirPath);
        $this->file = new SplFileInfo($this->filePath);
        $this->symlink = new SplFileInfo($this->symlinkPath);
        $this->hardlink = new SplFileInfo($this->hardlinkPath);
    }

    /**
     * __toString return the path filled in constructor
     */
    public function test__toString()
    {
        static::assertEquals($this->dirPath, (string) $this->dir);
        static::assertEquals($this->filePath, (string) $this->file);
        static::assertEquals($this->symlinkPath, (string) $this->symlink);
        static::assertEquals($this->hardlinkPath, (string) $this->hardlink);
    }

    /**
     * getPath return dir path that contain the file | So name should be getDirectoryContainerPath
     */
    public function testGetPath()
    {
        static::assertEquals(dirname($this->dirPath), $this->dir->getPath());
        static::assertEquals(dirname($this->filePath), $this->file->getPath());
        static::assertEquals(dirname($this->symlinkPath), $this->symlink->getPath());
        static::assertEquals(dirname($this->hardlinkPath), $this->hardlink->getPath());
    }


    /**
     * getRealPath return the full absolute Path with links resolution for symlinks, not for hard
     */
    public function testGetRealPath()
    {
        static::assertEquals(realpath($this->dirPath), $this->dir->getRealPath());
        static::assertEquals(realpath($this->filePath), $this->file->getRealPath());
        static::assertEquals(realpath($this->filePath), $this->symlink->getRealPath());
        static::assertNotEquals(realpath($this->filePath), $this->hardlink->getRealPath());
    }

    /**
     * getLinkTarget works only with symlink, in other case it is throw an exception
     */
    public function testGetLinkTarget()
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
     * Return the last component like basename() does
     */
    public function testGetFilename()
    {
        static::assertEquals(basename($this->dirPath), $this->dir->getFilename());
        static::assertEquals(basename($this->filePath), $this->file->getFilename());
        static::assertEquals(basename($this->symlinkPath), $this->symlink->getFilename());
        static::assertEquals(basename($this->hardlinkPath), $this->hardlink->getFilename());
    }

    /**
     * Get type is not very useful but here is... note that hard link return file
     */
    public function testGetType()
    {
        static::assertEquals('dir', $this->dir->getType());
        static::assertEquals('file', $this->file->getType());
        static::assertEquals('link', $this->symlink->getType());
        static::assertEquals('file', $this->hardlink->getType());
    }

    /**
     * Files, links and hardlinks returns TRUE
     */
    public function testIsFile()
    {
        static::assertFalse($this->dir->isFile());
        static::assertTrue($this->file->isFile());
        static::assertTrue($this->symlink->isFile());
        static::assertTrue($this->hardlink->isFile());
    }

    /**
     * Return TRUE if mode authorize reading , for symlink it the right of the pointed file
     */
    public function testIsReadable()
    {
        static::assertTrue($this->dir->isReadable());
        static::assertTrue($this->file->isReadable());
        static::assertTrue($this->symlink->isReadable());
        static::assertTrue($this->hardlink->isReadable());
        chmod($this->file, 0000);
        static::assertFalse($this->file->isReadable());
        static::assertFalse($this->symlink->isReadable());
        static::assertFalse($this->hardlink->isReadable());
    }

    /**
     * getPathName return path like it was passed in constructor
     */
    public function testGetPathname()
    {
        static::assertEquals($this->dirPath, $this->dir->getPathname());
        static::assertEquals($this->filePath, $this->file->getPathname());
        static::assertEquals($this->symlinkPath, $this->symlink->getPathname());
        static::assertEquals($this->hardlinkPath, $this->hardlink->getPathname());
    }

    /**
     * getInode return the ID node . Same Inode is returned for file and hardlink
     */
    public function testGetInode()
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
     * It return an RuntimeException if file not exist anymore
     */
    public function testGetSize()
    {
        $fileSize = $this->file->getSize();
        $symlinkSize = $this->file->getSize();
        $hardLinkSize = $this->file->getSize();
        static::assertEquals($fileSize, $symlinkSize);
        static::assertEquals($fileSize, $hardLinkSize);
        file_put_contents($this->filePath, str_repeat('0123456789', 50), FILE_APPEND);
        $fileSize2 = $this->file->getSize();
        // We can see than file size is not updated! ...
        static::assertEquals($fileSize, $fileSize2);
        static::assertEquals($fileSize2, $symlinkSize);
        static::assertEquals($fileSize2, $hardLinkSize);
        // ... But it is the updated size for hardlink and symlink :-/ !
        $symlinkSize2 = $this->symlink->getSize();
        $hardLinkSize2 = $this->hardlink->getSize();
        static::assertNotEquals($fileSize, $symlinkSize2);
        static::assertNotEquals($fileSize, $hardLinkSize2);
        // ... But if we clearstatcache it is ...
        clearstatcache(true, $this->filePath);
        $fileSize3 = $this->file->getSize();
        static::assertNotEquals($fileSize, $fileSize3);
        static::assertNotEquals($fileSize3, $symlinkSize);
        static::assertNotEquals($fileSize3, $hardLinkSize);
        // And what about if file disappear ?
        unlink($this->filePath);
        static::expectExceptionMessage(sprintf('SplFileInfo::getSize(): stat failed for %s', $this->filePath));
        $this->file->getSize();
    }

    /**
     * Get the last access to file
     * Access time directory never change
     *
     */
    public function testGetATime()
    {
        $dirATime = $this->dir->getATime();
        $fileATime = $this->file->getATime();
        $symlinkATime = $this->symlink->getATime();
        $hardlinkATime = $this->hardlink->getATime();

        sleep(1);

        file_get_contents($this->filePath);

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
     * Should get the creation time. So it will never change except if a newer
     * But in reality it return the modification time
     * Creation time directory never change
     */
    public function testGetCTime()
    {
        $dirCTime = $this->dir->getCTime();
        $fileCTime = $this->file->getCTime();
        $symlinkCTime = $this->symlink->getCTime();
        $hardlinkCTime = $this->hardlink->getCTime();

        sleep(1);

        file_get_contents($this->filePath);

        $dirCTime2 = $this->dir->getCTime();
        $fileCTime2 = $this->file->getCTime();
        $symlinkCTime2 = $this->symlink->getCTime();
        $hardlinkCTime2 = $this->hardlink->getCTime();

        static::assertEquals($dirCTime, $dirCTime2);
        static::assertEquals($fileCTime, $fileCTime2);
        static::assertEquals($symlinkCTime, $symlinkCTime2);
        static::assertEquals($hardlinkCTime, $hardlinkCTime2);

        sleep(1);

        file_put_contents($this->filePath, 'some data', FILE_APPEND);

        $dirCTime2 = $this->dir->getCTime();
        $fileCTime2 = $this->file->getCTime();
        $symlinkCTime2 = $this->symlink->getCTime();
        $hardlinkCTime2 = $this->hardlink->getCTime();

        static::assertEquals($dirCTime, $dirCTime2);
        static::assertNotEquals($fileCTime, $fileCTime2);
        static::assertNotEquals($symlinkCTime, $symlinkCTime2);
        static::assertNotEquals($hardlinkCTime, $hardlinkCTime2);
    }

    /**
     * Should return the modification time
     */
    public function testGetMTime()
    {
        $dirMTime = $this->dir->getMTime();
        $fileMTime = $this->file->getMTime();
        $symlinkMTime = $this->symlink->getMTime();
        $hardlinkMTime = $this->hardlink->getMTime();

        sleep(1);

        file_get_contents($this->filePath);

        $dirMTime2 = $this->dir->getMTime();
        $fileMTime2 = $this->file->getMTime();
        $symlinkMTime2 = $this->symlink->getMTime();
        $hardlinkMTime2 = $this->hardlink->getMTime();

        static::assertEquals($dirMTime, $dirMTime2);
        static::assertEquals($fileMTime, $fileMTime2);
        static::assertEquals($symlinkMTime, $symlinkMTime2);
        static::assertEquals($hardlinkMTime, $hardlinkMTime2);

        sleep(1);

        file_put_contents($this->filePath, 'some data', FILE_APPEND);

        $dirMTime2 = $this->dir->getMTime();
        $fileMTime2 = $this->file->getMTime();
        $symlinkMTime2 = $this->symlink->getMTime();
        $hardlinkMTime2 = $this->hardlink->getMTime();

        static::assertEquals($dirMTime, $dirMTime2);
        static::assertNotEquals($fileMTime, $fileMTime2);
        static::assertNotEquals($symlinkMTime, $symlinkMTime2);
        static::assertNotEquals($hardlinkMTime, $hardlinkMTime2);
    }

//    public function testGetPerms()
//    {
//
//    }
//
//    public function testGetBasename()
//    {
//
//    }
//
//    public function testIsDir()
//    {
//
//    }
//
//    public function testGetOwner()
//    {
//
//    }
//
//    public function testGetGroup()
//    {
//
//    }
//
//    public function testSetInfoClass()
//    {
//
//    }
//
//    public function testIsExecutable()
//    {
//
//    }
//
//    public function testGetPathInfo()
//    {
//
//    }
//
//    public function testGetExtension()
//    {
//
//    }
//
//    public function testIsLink()
//    {
//
//    }
//
//    public function testIsWritable()
//    {
//
//    }
//
//    public function testOpenFile()
//    {
//
//    }
}
