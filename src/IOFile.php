<?php

namespace MockingMagician\Organic;


class IOFile implements IOFileInterface
{
    /** @var resource */
    private $handler;
    private $path;
    private $openMode;

    /**
     * ReadWriteFileInterface constructor.
     * @param string $path
     * @param string $openMode
     * @throws \Exception
     */
    public function __construct(string $path, string $openMode = "r")
    {
        $this->path = $path;
        $this->openMode = $openMode;
        $this->handler = $this->openHandler();
    }

    /**
     * Determine whether the end of file has been reached
     * @return bool
     */
    public function eof(): bool
    {
        return feof($this->handler);
    }

    /**
     * Forces a write of all buffered output to the file.
     * @return bool
     */
    public function flush(): bool
    {
        return fflush($this->handler);
    }

    /**
     * Gets a character from the file.
     * @return string
     */
    public function getChar(): string
    {
        return fgetc($this->handler);
    }

    /**
     * Returns a string containing the next line from the file
     * @return string
     */
    public function getCurrentLine(): string
    {
        return fgets($this->handler);
    }

    /**
     * Locks or unlocks the file in the same portable way as flock().
     * @param int $operation
     * @param bool $wouldBlock
     * @return bool
     */
    public function lock(int $operation, bool $wouldBlock = false): bool
    {
        return flock($this->handler, $operation, $wouldBlock);
    }

    /**
     * Reads to EOF on the given file pointer from the current position and writes the results to the output buffer.
     * @return int
     */
    public function passThrough(): int
    {
        return fpassthru($this->handler);
    }

    /**
     * Reads the given number of bytes from the file.
     * @param int $length
     * @return string
     */
    public function read(int $length): string
    {
        return fread($this->handler, $length);
    }

    /**
     * Reads a line from the file and interprets it according to the specified format, which is described in the
     * documentation for sprintf().
     * @param string $format
     * @param array $mixed
     * @return mixed
     */
    public function scanFormat(string $format, ...$mixed)
    {
        return fscanf($this->handler, ...$mixed);
    }

    /**
     * Seek to a position in the file measured in bytes from the beginning of the file, obtained by adding offset to
     * the position specified by whence.
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool
    {
        return fseek($this->handler, $whence);
    }

    /**
     * Return current file position
     * @return int
     */
    public function tell(): int
    {
        return ftell($this->handler);
    }

    /**
     * Truncates the file to size bytes.
     * If size is larger than the file it is extended with null bytes.
     * If size is smaller than the file, the extra data will be lost.
     * @param int $size
     * @return bool
     */
    public function truncate(int $size): bool
    {
        return ftruncate($this->handler, $size);
    }

    /**
     * Writes the contents of string to the file
     * If the length argument is given, writing will stop after length bytes have been written
     * or the end of string is reached, whichever comes first.
     * @param string $str
     * @param int|null $length
     * @return int - the number of bytes written, or 0 on error.
     */
    public function write(string $str, int $length = null): int
    {
        return fwrite($this->handler, $str, $length);
    }

    /**
     * Reads entire file into a string
     * It close the internal file handler before calling file_get_contents()
     * and after operate reopen a new one with the same parameters
     * @return string
     * @throws \Exception
     */
    public function getContent(): string
    {
        $this->closeHandler();
        $content = file_get_contents($this->path);
        $this->openHandler();

        return $content;
    }

    /**
     * Write data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX
     * @param mixed $data
     * @return int
     * @throws \Exception
     */
    public function putContent($data): int
    {
        $this->closeHandler();
        $bytes = file_put_contents($this->path, $data, LOCK_EX);
        $this->openHandler();

        if (is_bool($bytes)) {
            throw new \Exception();
        }

        return $bytes;
    }

    /**
     * Append data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX | LOCK_APPEND
     * @param mixed $data
     * @return int
     * @throws \Exception
     */
    public function addContent($data): int
    {
        $this->closeHandler();
        $bytes = file_put_contents($this->path, $data, LOCK_EX | FILE_APPEND);
        $this->openHandler();

        if (is_bool($bytes)) {
            throw new \Exception();
        }

        return $bytes;
    }

    /**
     * @throws \Exception
     */
    protected function openHandler()
    {
        $handler = fopen($this->path, $this->openMode);
        if (is_resource($handler)) {
            $this->handler = $handler;
            return;
        }

        throw new \Exception();
    }

    protected function closeHandler()
    {
        if (is_resource($this->handler)) {
            fclose($this->handler);
        }
    }
}
