# Install

```bash
composer require mocking-magician/organic
```

```php
<?

use \MockingMagician\Organic\Facade\FileSystem;

/** @var \MockingMagician\Organic\Inode\File $file */
$file = FileSystem::getFile('path/to/file.ext');

$file->getDirectoryContainerPath();
$file->getObjectPath();
$file->getRealPath();
$file->getName();
$file->getExtension();
$file->getPermissions();
$file->getAccessTime();
$file->getModificationTime();
$file->getChangeTime();
$file->getSize();

/** @var MockingMagician\Organic\IO\IOFile $io */
$io = $file->getIO();

$io->write('something');
$io->tell();
$io->truncate(25);
$io->passThrough();
$io->read(250);
$io->getContent();
$io->getChar();
$io->getCurrentLine();
$io->addContent('some data to append');
$io->seek(13);
$io->flush();
$io->eof();
$io->lock(LOCK_EX, $wouldBlock);
$io->putContent('that new content');
$io->scanFormat('FS');


//TODO Continue documentation
```
