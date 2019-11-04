<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\IO;

use MockingMagician\Organic\Exception\IOException;

/**
 * Class IOFile.
 *
 * @codeCoverageIgnore
 */
class IOFile implements IOFileInterface
{
    /** @var resource */
    private $handler;
    private $path;
    private $openMode;

    /**
     * ReadWriteFileInterface constructor.
     *
     * @param string $path
     * @param string $openMode
     *
     * @throws \Exception
     */
    public function __construct(string $path, string $openMode = 'r')
    {
        $this->path = $path;
        $this->openMode = $openMode;
        $this->openHandler();
    }

    public function __destruct()
    {
        $this->closeHandler();
    }

    /**
     * Determine whether the end of file has been reached.
     *
     * @return bool
     */
    public function eof(): bool
    {
        return \feof($this->handler);
    }

    /**
     * Forces a write of all buffered output to the file.
     *
     * @return bool
     */
    public function flush(): bool
    {
        return \fflush($this->handler);
    }

    /**
     * Gets a character from the file.
     *
     * @throws IOException
     *
     * @return string
     */
    public function getChar(): string
    {
        $char = \fgetc($this->handler);
        if (false === $char) {
            throw new IOException('No char to get');
        }

        return $char;
    }

    /**
     * Returns a string containing the next line from the file.
     *
     * @throws IOException
     *
     * @return string
     */
    public function getCurrentLine(): string
    {
        $line = \fgets($this->handler);
        if (false === $line) {
            throw new IOException('No line to get');
        }

        return $line;
    }

    /**
     * Locks or unlocks the file in the same portable way as flock().
     *
     * @param int $operation
     * @param int $wouldBlock takes value `1` if file is locked by another, `0` if not
     *
     * @return bool
     */
    public function lock(int $operation, int &$wouldBlock = null): bool
    {
        return \flock($this->handler, $operation, $wouldBlock);
    }

    /**
     * Reads to EOF on the given file pointer from the current position and writes the results to the output buffer.
     *
     * @return int
     */
    public function passThrough(): int
    {
        return \fpassthru($this->handler);
    }

    /**
     * Reads the given number of bytes from the file.
     *
     * @param int $length
     *
     * @throws IOException
     *
     * @return string
     */
    public function read(int $length): string
    {
        $read = \fread($this->handler, $length);
        if (false === $read) {
            throw new IOException('Read has failed');
        }

        return $read;
    }

    /**
     * Reads a line from the file and interprets it according to the specified format, which is described in the
     * documentation for sprintf().
     *
     * @param string $format
     * @param array  $mixed
     *
     * @return array|int
     */
    public function scanFormat(string $format, ...$mixed)
    {
        return \fscanf($this->handler, ...$mixed);
    }

    /**
     * Seek to a position in the file measured in bytes from the beginning of the file, obtained by adding offset to
     * the position specified by whence.
     *
     * @param int $offset
     * @param int $whence
     *
     * @return bool
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool
    {
        return 0 === \fseek($this->handler, $whence);
    }

    /**
     * Return current file position.
     *
     * @throws IOException
     *
     * @return int
     */
    public function tell(): int
    {
        $tell = \ftell($this->handler);
        if (false === $tell) {
            throw new IOException('tell has failed');
        }
    }

    /**
     * Truncates the file to size bytes.
     * If size is larger than the file it is extended with null bytes.
     * If size is smaller than the file, the extra data will be lost.
     *
     * @param int $size
     *
     * @return bool
     */
    public function truncate(int $size): bool
    {
        return \ftruncate($this->handler, $size);
    }

    /**
     * Writes the contents of string to the file
     * If the length argument is given, writing will stop after length bytes have been written
     * or the end of string is reached, whichever comes first.
     *
     * @param string   $str
     * @param null|int $length
     *
     * @throws IOException
     *
     * @return int - the number of bytes written, or 0 on error
     */
    public function write(string $str, int $length = null): int
    {
        if (\is_int($length)) {
            $write = \fwrite($this->handler, $str, $length);
        } else {
            $write = \fwrite($this->handler, $str);
        }
        if (false === $write) {
            throw new IOException('write has failed');
        }

        return $write;
    }

    /**
     * Reads entire file into a string
     * It close the internal file handler before calling file_get_contents()
     * and after operate reopen a new one with the same parameters.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getContent(): string
    {
        $this->closeHandler();
        $content = \file_get_contents($this->path);
        $this->openHandler();

        if (false === $content) {
            throw new IOException('getContent has failed');
        }

        return $content;
    }

    /**
     * Write data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX.
     *
     * @param mixed $data
     *
     * @throws \Exception
     *
     * @return int
     */
    public function putContent($data): int
    {
        $this->closeHandler();
        $bytes = \file_put_contents($this->path, $data, LOCK_EX);
        $this->openHandler();

        if (\is_bool($bytes)) {
            throw new \Exception();
        }

        return $bytes;
    }

    /**
     * Append data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX | LOCK_APPEND.
     *
     * @param mixed $data
     *
     * @throws \Exception
     *
     * @return int
     */
    public function addContent($data): int
    {
        $this->closeHandler();
        $bytes = \file_put_contents($this->path, $data, LOCK_EX | FILE_APPEND);
        $this->openHandler();

        if (\is_bool($bytes)) {
            throw new \Exception();
        }

        return $bytes;
    }

    /**
     * @throws \Exception
     */
    protected function openHandler(): void
    {
        $handler = \fopen($this->path, $this->openMode);
        if (\is_resource($handler)) {
            $this->handler = $handler;

            return;
        }

        throw new \Exception();
    }

    protected function closeHandler(): void
    {
        if (\is_resource($this->handler)) {
            \fclose($this->handler);
        }
    }
}
