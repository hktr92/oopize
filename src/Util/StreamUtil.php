<?php
declare(strict_types=1);

namespace Oopize\Util;

use function fclose;
use function feof;
use function fgetc;
use function fgets;
use function filesize;
use function fread;
use function is_resource;

/**
 * Class StreamUtil
 * @package Oopize\Util
 * @since   0.3.0
 */
final class StreamUtil {
    public const
        MODE_READ_ONLY = 'r',
        MODE_READ_ONLY_BINARY = 'rb',
        MODE_READ_WRITE = 'w+',
        MODE_READ_WRITE_PREPEND = 'r+',
        MODE_WRITE_ONLY_OVERRIDE = 'w',
        MODE_WRITE_ONLY_APPEND = 'a',
        MODE_READ_WRITE_APPEND = 'a+';


    private $resource;

    private $path;
    private $mode;

    private $open = false;

    public function __construct(?string $path = null, ?string $mode = null) {
        $this->path = $path;
        $this->mode = $mode;
    }

    public static function fromExisting($resource): StreamUtil {
        $self = new self;
        $self->setResource($resource);

        return $self;
    }

    public function setResource($resource): void {
        $this->resource = $resource;
        $this->open     = is_resource($resource);
    }

    public function open(): void {
        $this->resource = fopen($this->path, $this->mode);
        $this->open     = is_resource($this->resource);
    }

    public function close(): void {
        fclose($this->resource);
    }

    public function getResource() {
        return $this->resource;
    }

    public function getSize(): int {
        return filesize($this->path);
    }

    public function readBinary() {
        return fread(
            $this->resource,
            $this->getSize()
        );
    }

    public function resourceDepleted(): bool {
        return feof($this->resource);
    }

    public function readLines($callback) {
        while (false === $this->resourceDepleted()) {
            $callback(
                fgets($this->resource),
                $this->resourceDepleted(),
                $this
            );
        }
    }

    public function readCharacters($callback): array {
        $chars = new ArrayUtil;

        while (false === $this->resourceDepleted()) {
            $callback(
                fgetc($this->resource),
                $this->resourceDepleted(),
                $this
            );
        }
    }
}
