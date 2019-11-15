<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Size;

/**
 * Class Size.
 *
 * @method int   bytes()
 * @method float kiloBytes(int $precision = 0)
 * @method float megaBytes(int $precision = 0)
 * @method float gigaBytes(int $precision = 0)
 * @method float teraBytes(int $precision = 0)
 * @method float kibiBytes(int $precision = 0)
 * @method float mebiBytes(int $precision = 0)
 * @method float gibiBytes(int $precision = 0)
 * @method float tebiBytes(int $precision = 0)
 * @method int   bits()
 */
class Size
{
    private $sizeInBytes;

    public function __construct(int $sizeInBytes)
    {
        $this->sizeInBytes = $sizeInBytes;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @throws \ErrorException
     *
     * @return float|int
     */
    public function __call($name, $arguments)
    {
        if ('bytes' === $name) {
            return $this->sizeInBytes;
        }

        if ('bits' === $name) {
            return $this->sizeInBytes * 8;
        }

        $bytes = \explode('Bytes', $name);
        if (2 === \count($bytes)) {
            $bytes = $bytes[0];

            if (!\is_int($precision = $arguments[0] ?? 0)) {
                throw new \ErrorException(
                    \sprintf(
                        '%s::%s() expects parameter 1 to be int, %s given',
                        static::class,
                        $name,
                        \gettype($precision)
                    ),
                    0,
                    E_WARNING
                );
            }

            if ('kilo' === $bytes) {
                return \round($this->sizeInBytes / 1000, $precision);
            }

            if ('mega' === $bytes) {
                return \round($this->sizeInBytes / (1000 ** 2), $precision);
            }

            if ('giga' === $bytes) {
                return \round($this->sizeInBytes / (1000 ** 3), $precision);
            }

            if ('tera' === $bytes) {
                return \round($this->sizeInBytes / (1000 ** 4), $precision);
            }

            if ('kibi' === $bytes) {
                return \round($this->sizeInBytes / 1024, $precision);
            }

            if ('mebi' === $bytes) {
                return \round($this->sizeInBytes / (1024 ** 2), $precision);
            }

            if ('gibi' === $bytes) {
                return \round($this->sizeInBytes / (1024 ** 3), $precision);
            }

            if ('tebi' === $bytes) {
                return \round($this->sizeInBytes / (1024 ** 4), $precision);
            }
        }

        throw new \ErrorException(
            \sprintf('Call to undefined method %s::%s()', static::class, $name),
            0,
            E_WARNING
        );
    }
}
