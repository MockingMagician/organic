<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\IO;

interface IOFileInterface
{
    /**
     * LOCK_* refers to $operations of lock().
     */
    public const LOCK_SH = LOCK_SH; // to acquire a shared lock (reader).
    public const LOCK_EX = LOCK_EX; // to acquire an exclusive lock (writer).
    public const LOCK_UN = LOCK_UN; // to release a lock (shared or exclusive).
    public const LOCK_NB = LOCK_NB; // to not block while locking.

    /**
     * SEEK_* refers to $whence of seek().
     */
    public const SEEK_SET = SEEK_SET; // Set position equal to offset bytes.
    public const SEEK_CUR = SEEK_CUR; // Set position to current location plus offset.
    public const SEEK_END = SEEK_END; // Set position to end-of-file plus offset.

    /**
     * Determine whether the end of file has been reached.
     */
    public function eof(): bool;

    /**
     * Forces a write of all buffered output to the file.
     */
    public function flush(): bool;

    /**
     * Gets a character from the file.
     */
    public function getChar(): string;

    /**
     * Returns a string containing the current line from the file.
     */
    public function getCurrentLine(): string;

    /**
     * Locks or unlocks the file in the same portable way as flock().
     *
     * @param int $wouldBlock takes value `1` if file is locked by another, `0` if not
     */
    public function lock(int $operation, int &$wouldBlock = null): bool;

    /**
     * Reads to EOF on the given file pointer from the current position and writes the results to the output buffer.
     */
    public function passThrough(): int;

    /**
     * Reads the given number of bytes from the file.
     */
    public function read(int $length): string;

    /**
     * Reads a line from the file and interprets it according to the specified format, which is described in the
     * documentation for sprintf().
     *
     * @param array $mixed
     *
     * @return mixed
     */
    public function scanFormat(string $format, ...$mixed);

    /**
     * Seek to a position in the file measured in bytes from the beginning of the file, obtained by adding offset to
     * the position specified by whence.
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool;

    /**
     * Return current file position.
     */
    public function tell(): int;

    /**
     * Truncates the file to size bytes.
     * If size is larger than the file it is extended with null bytes.
     * If size is smaller than the file, the extra data will be lost.
     */
    public function truncate(int $size): bool;

    /**
     * Writes the contents of string to the file
     * If the length argument is given, writing will stop after length bytes have been written
     * or the end of string is reached, whichever comes first.
     *
     * @return int - the number of bytes written, or 0 on error
     */
    public function write(string $str, int $length = null): int;

    /**
     * Reads entire file into a string
     * It close the internal file handler before calling file_get_contents()
     * and after operate reopen a new one with the same parameters.
     */
    public function getContent(): string;

    /**
     * Write data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX.
     *
     * @param mixed $data
     */
    public function putContent($data): int;

    /**
     * Append data to the file
     * It close the internal file handler before calling file_put_contents()
     * and after operate reopen a new one with the same parameters
     * file_put_contents() is called with LOCK_EX | LOCK_APPEND.
     *
     * @param mixed $data
     */
    public function addContent($data): int;
}
