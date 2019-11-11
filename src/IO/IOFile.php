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
    /**
     * Open for reading only;
     * place the file pointer at the beginning of the file.
     */
    public const MODE_READ_FROM_BEGIN = 'r';
    public const MODE_R =  'r';
    public const MODE_RB = 'rb';
    /**
     * Open for reading and writing;
     * place the file pointer at the beginning of the file.
     */
    public const MODE_READ_WRITE_FROM_BEGIN = 'r+';
    public const MODE_R_PLUS = 'r+';
    public const MODE_R_PLUS_B = 'r+b';
    /**
     * Open for writing only;
     * place the file pointer at the beginning of the file and truncate the file to zero length.
     * If the file does not exist, attempt to create it.
     */
    public const MODE_WRITE_TRUNCATE_FROM_BEGIN = 'w';
    public const MODE_W =  'w';
    public const MODE_WB = 'wb';
    /**
     * Open for reading and writing;
     * place the file pointer at the beginning of the file and truncate the file to zero length.
     * If the file does not exist, attempt to create it.
     */
    public const MODE_READ_WRITE_TRUNCATE_FROM_BEGIN = 'w+';
    public const MODE_W_PLUS = 'w+';
    public const MODE_W_PLUS_B = 'w+b';
    /**
     * Open for writing only;
     * place the file pointer at the end of the file.
     * If the file does not exist, attempt to create it.
     * In this mode, fseek() has no effect, writes are always appended.
     */
    public const MODE_WRITE_FROM_END = 'a';
    public const MODE_A =  'a';
    public const MODE_AB = 'ab';
    /**
     * Open for reading and writing;
     * place the file pointer at the end of the file.
     * If the file does not exist, attempt to create it.
     * In this mode, fseek() only affects the reading position, writes are always appended.
     */
    public const MODE_READ_WRITE_FROM_END = 'a+';
    public const MODE_A_PLUS = 'a+';
    public const MODE_A_PLUS_B = 'a+b';
    /**
     * Create and open for writing only;
     * place the file pointer at the beginning of the file.
     * If the file already exists, the fopen() call will fail by returning FALSE and generating an error of level E_WARNING.
     * If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call.
     */
    public const MODE_WRITE_NEW = 'x';
    public const MODE_X =  'x';
    public const MODE_XB = 'xb';
    /**
     * Create and open for reading and writing; otherwise it has the same behavior as 'x'.
     */
    public const MODE_READ_WRITE_NEW = 'x+';
    public const MODE_X_PLUS = 'x+';
    public const MODE_X_PLUS_B = 'x+b';
    /**
     * Open the file for writing only.
     * If the file does not exist, it is created.
     * If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x').
     * The file pointer is positioned on the beginning of the file.
     * This may be useful if it's desired to get an advisory lock (see flock()) before attempting to modify the file,
     * as using 'w' could truncate the file before the lock was obtained (if truncation is desired, ftruncate() can be used after the lock is requested).
     */
    public const MODE_WRITE_FROM_BEGIN_WITH_CREATE = 'c';
    public const MODE_C =  'c';
    public const MODE_CB = 'cb';
    /**
     * Open the file for reading and writing; otherwise it has the same behavior as 'c'.
     */
    public const MODE_READ_WRITE_FROM_BEGIN_WITH_CREATE = 'c+';
    public const MODE_C_PLUS = 'c+';
    public const MODE_C_PLUS_B = 'c+b';
    /**
     * Set close-on-exec flag on the opened file descriptor. Only available in PHP compiled on POSIX.1-2008 conform systems.
     *
     * A file descriptor has a close-on-exec flag which indicates if the file descriptor will be inherited or not.
     *
     * On UNIX, if the close-on-exec flag is set, the file descriptor is not inherited:
     * it will be closed at the execution of child processes; otherwise the file descriptor is inherited by child processes.
     *
     * On Windows, if the close-on-exec flag is set, the file descriptor is not inherited;
     * the file descriptor is inherited by child processes if the close-on-exec flag is cleared
     * and if CreateProcess() is called with the bInheritHandles parameter set to TRUE (when subprocess.Popen is created with close_fds=False for example).
     * Windows does not have "close-on-exec" flag but an inheritance flag which is just the opposite value.
     * For example, setting close-on-exec flag means clearing the HANDLE_FLAG_INHERIT flag of a handle.
     */
    public const MODE_CLOSE_ON_EXEC = 'e';

    public const MODES_VALID = [
        self::MODE_RB,
        self::MODE_R_PLUS_B,
        self::MODE_WB,
        self::MODE_W_PLUS_B,
        self::MODE_AB,
        self::MODE_A_PLUS_B,
    ];

    /** @var resource */
    private $handler;
    private $path;
    private $openMode;

    /**
     * ReadWriteFileInterface constructor.
     *
     * @throws IOException
     */
    public function __construct(string $path, string $openMode = self::MODE_RB)
    {
        if (!in_array($openMode, self::MODES_VALID)) {
            throw new IOException(sprintf(
                'open mode `%s` is not valid. Must be one of %s',
                $openMode,
                implode(', ', self::MODES_VALID)
            ));
        }
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
     */
    public function eof(): bool
    {
        return \feof($this->handler);
    }

    /**
     * Forces a write of all buffered output to the file.
     */
    public function flush(): bool
    {
        return \fflush($this->handler);
    }

    /**
     * Gets a character from the file.
     *
     * @throws IOException
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
     * @param int $wouldBlock takes value `1` if file is locked by another, `0` if not
     */
    public function lock(int $operation, int &$wouldBlock = null): bool
    {
        return \flock($this->handler, $operation, $wouldBlock);
    }

    /**
     * Reads to EOF on the given file pointer from the current position and writes the results to the output buffer.
     */
    public function passThrough(): int
    {
        return \fpassthru($this->handler);
    }

    /**
     * Reads the given number of bytes from the file.
     *
     * @throws IOException
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
     * @param array $mixed
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
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool
    {
        return 0 === \fseek($this->handler, $whence);
    }

    /**
     * Return current file position.
     *
     * @throws IOException
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
     * @throws IOException
     */
    protected function openHandler(): void
    {
        $handler = \fopen($this->path, $this->openMode);
        if (\is_resource($handler)) {
            $this->handler = $handler;

            return;
        }

        throw new IOException(
            sprintf('fopen has failed for path `%s` with mode `%s`', $this->path, $this->openMode)
        );
    }

    protected function closeHandler(): void
    {
        if (\is_resource($this->handler)) {
            \fclose($this->handler);
        }
    }
}
