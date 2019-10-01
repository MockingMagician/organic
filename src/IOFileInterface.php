<?php

namespace MockingMagician\Organic;


interface IOFileInterface
{
    /**
     * LOCK_* refers to $operations of lock()
     */
    public const LOCK_SH = LOCK_SH; // to acquire a shared lock (reader).
    public const LOCK_EX = LOCK_EX; // to acquire an exclusive lock (writer).
    public const LOCK_UN = LOCK_UN; // to release a lock (shared or exclusive).
    public const LOCK_NB = LOCK_NB; // to not block while locking.

    /**
     * SEEK_* refers to $whence of seek()
     */
    public const SEEK_SET = SEEK_SET; // Set position equal to offset bytes.
    public const SEEK_CUR = SEEK_CUR; // Set position to current location plus offset.
    public const SEEK_END = SEEK_END; // Set position to end-of-file plus offset.

    /**
     * Determine whether the end of file has been reached
     * @return bool
     */
    public function eof(): bool;

    /**
     * Forces a write of all buffered output to the file.
     * @return bool
     */
    public function flush(): bool;

    /**
     * Gets a character from the file.
     * @return string
     */
    public function getChar(): string;

    /**
     * Returns a string containing the current line from the file
     * @return string
     */
    public function getCurrentLine(): string;

    /**
     * Locks or unlocks the file in the same portable way as flock().
     * @param int $operation
     * @param bool $wouldBlock
     * @return bool
     */
    public function lock(int $operation, bool $wouldBlock = false): bool;

    /**
     * Reads to EOF on the given file pointer from the current position and writes the results to the output buffer.
     * @return int
     */
    public function passThrough(): int;

    /**
     * Reads the given number of bytes from the file.
     * @param int $length
     * @return string
     */
    public function read(int $length): string;

    /**
     * Reads a line from the file and interprets it according to the specified format, which is described in the
     * documentation for sprintf().
     * @param string $format
     * @param array $mixed
     * @return mixed
     */
    public function scanFormat(string $format, ...$mixed);

    /**
     * Seek to a position in the file measured in bytes from the beginning of the file, obtained by adding offset to
     * the position specified by whence.
     * @param int $offset
     * @param int $whence
     * @return bool
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool;

    /**
     * Return current file position
     * @return int
     */
    public function tell(): int;

    /**
     * Truncates the file to size bytes.
     * If size is larger than the file it is extended with null bytes.
     * If size is smaller than the file, the extra data will be lost.
     * @param int $size
     * @return bool
     */
    public function truncate(int $size): bool;

    /**
     * Writes the contents of string to the file
     * If the length argument is given, writing will stop after length bytes have been written
     * or the end of string is reached, whichever comes first.
     * @param string $str
     * @param int|null $length
     * @return int - the number of bytes written, or 0 on error.
     */
    public function write(string $str, int $length = null): int;

    /**
     * Reads entire file into a string
     * It close the internal file handler before calling file_get_contents()
     * and after operate reopen a new one with the same parameters
     * @return string
     */
    public function getContent(): string;

    /**
     * Write data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX
     * @param mixed $data
     * @return int
     */
    public function putContent($data): int;

    /**
     * Append data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX | LOCK_APPEND
     * @param mixed $data
     * @return int
     */
    public function addContent($data): int;
}
