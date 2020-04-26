<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonException;
use JsonSerializable;
use function array_diff;
use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_pop;
use function array_push;
use function array_reverse;
use function array_shift;
use function array_unique;
use function array_values;
use function count;
use function end;
use function explode;
use function in_array;
use function is_array;
use function join;
use function reset;
use const JSON_ERROR_NONE;

/**
 * Class ArrayUtil
 * @package Oopize\Util
 * @since   0.1
 */
class ArrayUtil implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable {
    /**
     * @var array
     */
    private $data;

    /**
     * ArrayUtil constructor.
     *
     * @param array $array
     */
    public function __construct(array $array = []) {
        $this->data = $array;
    }

    /**
     * @param string $text
     * @param string $splitBy
     *
     * @return ArrayUtil
     */
    public static function fromString(string $text, string $splitBy): ArrayUtil {
        return new self(explode($splitBy, $text));
    }

    /**
     * @param string $json
     *
     * @return ArrayUtil
     *
     * @throws JsonException
     */
    public static function fromJson(string $json): ArrayUtil {
        $decoded = JsonUtil::parse($json);

        $jsonError = JsonUtil::getError();
        if (JSON_ERROR_NONE !== $jsonError['code']) {
            throw new JsonException($jsonError['message']);
        }

        return new self($decoded);
    }

    /**
     * @param string $jsonFile
     *
     * @return ArrayUtil
     *
     * @throws InvalidArgumentException
     * @throws JsonException
     */
    public static function fromJsonFile(string $jsonFile): ArrayUtil {
        if (false === FileUtil::exists($jsonFile)) {
            throw new JsonException("Json file '{$jsonFile} does not exist.");
        }

        return self::fromJson(FileUtil::readContents($jsonFile) ?? []);
    }

    /**
     * @param $object
     *
     * @return ArrayUtil
     */
    public static function fromObject($object): ArrayUtil {
        $className = ClassUtil::getName($object);
        $self      = __METHOD__;

        if (false === ClassUtil::hasMethod($object, 'toArray')) {
            throw new InvalidArgumentException(
                StringUtil::format(
                    "Your object instance of %s must implement method '%s::toArray()' in order to use %s.",
                    [
                        $className,
                        $className,
                        $self,
                    ]
                )
            );
        }

        return new self($object->toArray());
    }

    /**
     * @param array $data
     * @param array $expectedKeys
     *
     * @return array
     */
    public static function safeExtract(array $data, array $expectedKeys): array {
        $ret  = [];
        $keys = array_keys($data);

        foreach ($expectedKeys as $key => $value) {
            if (false === in_array($key, $keys, true)) {
                $ret[$key] = $data[$key];

                continue;
            }

            $ret[$key] = $value;
        }

        return $ret;
    }

    /**
     * @param string|int $index
     *
     * @return mixed|null
     */
    public function get($index) {
        return $this->data[$index] ?? null;
    }

    /**
     * @param string|int $key   String key names are preferred rather than numeric indexes, but it also works fine with
     *                          numeric indexes.
     * @param mixed      $value The value to be kept in memory.
     */
    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    /**
     * @param string|int $index
     *
     * @return bool
     */
    public function exists($index): bool {
        return array_key_exists($index, $this->data);
    }

    /**
     * @param string|int $element
     * @param bool       $strict
     *
     * @return bool
     */
    public function contains($element, bool $strict = true): bool {
        return in_array($element, $this->data, $strict);
    }

    /**
     * @return bool
     */
    public function empty(): bool {
        return 0 === $this->count();
    }

    /**
     * @param mixed $element
     */
    public function add($element): void {
        array_push($this->data, $element);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset) {
        return $this->exists($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return array|mixed|null
     */
    public function offsetGet($offset) {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @param bool  $override
     */
    public function offsetSet($offset, $value, bool $override = false): void {
        if ($override) {
            $this->data[$offset] = $value;
        }

        $this->add($value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @return int
     */
    public function count(): int {
        return count($this->data);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->toArray());
    }

    /**
     * @param array $array
     *
     * @return ArrayUtil
     */
    public function merge(array $array): ArrayUtil {
        return new self(array_merge($this->data, $array));
    }

    /**
     * @param array $array
     *
     * @return ArrayUtil
     */
    public function diff(array $array): ArrayUtil {
        return new self(array_diff($this->data, $array));
    }

    /**
     * @TODO improve this one.
     *
     * @param array $other
     *
     * @return ArrayUtil
     */
    public function deepDiff(array $other): ArrayUtil {
        $result = new ArrayUtil;

        foreach ($this->data as $key => $val) {
            if (isset($other[$key])) {
                if (is_array($val) && $other[$key]) {
                    $result->set($key, $this->deepDiff($other[$key]));
                }
            } else {
                $result->set($key, $val);
            }
        }

        return $result;
    }

    /**
     * @param array $first
     * @param array $second
     *
     * @return ArrayUtil
     */
    public static function diffMulti(array $first = [], array $second = []): ArrayUtil {
        $result = new ArrayUtil;

        foreach ($first as $key => $val) {
            if (isset($second[$key])) {
                if (is_array($val) && $second[$key]) {
                    $result->set($key, self::diffMulti($val, $second[$key]));
                }
            } else {
                $result->set($key, $val);
            }
        }

        return $result;
    }

    /**
     * @param Closure $callback
     * @param null    $bindTo
     *
     * @return Closure
     */
    private function bindCallback(Closure $callback, $bindTo = null): Closure {
        return Closure::bind($callback, $bindTo ?? $this);
    }

    /**
     * @param Closure $callback
     * @param object  $bindTo
     *
     * @return ArrayUtil
     */
    public function map(Closure $callback, $bindTo): ArrayUtil {
        $processed = array_map($this->bindCallback($callback, $bindTo), $this->data);

        return new self($processed);
    }

    /**
     * @param Closure $callback
     *
     * @return mixed
     */
    public function find(Closure $callback) {
        $processed = new ArrayUtil(
            array_filter(
                $this->data,
                $this->bindCallback($callback)
            )
        );

        if ($processed->empty()) {
            return null;
        }

        return $processed->getValues()->first();
    }

    /**
     * @return ArrayUtil
     */
    public function getValues(): ArrayUtil {
        return new self(array_values($this->data));
    }

    /**
     * @return mixed|null
     */
    public function first() {
        return reset($this->data)
            ?: null;
    }

    /**
     * @return mixed|null
     */
    public function last() {
        return end($this->data)
            ?: null;
    }

    /**
     * @return ArrayUtil
     */
    public function getUnique(): ArrayUtil {
        return new self(array_unique($this->data));
    }

    /**
     * @return ArrayUtil
     */
    public function getKeys(): ArrayUtil {
        return new self(array_keys($this->data));
    }

    /**
     * @param string $output
     */
    public function toJsonFile(string $output): void {
        FileUtil::writeContents($output, $this->toJson());
    }

    /**
     * @return string
     */
    public function toJson(): string {
        return JsonUtil::stringify($this->data);
    }

    /**
     * @param string $delimiter
     *
     * @return string
     */
    public function toString(string $delimiter = ''): string {
        return join($delimiter, $this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array {
        $tmp = [];

        foreach ($this->data as $key => $value) {
            if (ClassUtil::isClass($value) && ClassUtil::hasMethod($value, 'toArray')) {
                $tmp[$key] = $value->toArray();
            } else {
                $tmp[$key] = $value;
            }
        }

        return $tmp;
    }

    /**
     * @param Closure $callback
     * @param object  $bindTo
     *
     * @return ArrayUtil
     */
    public function filter(Closure $callback, $bindTo): ArrayUtil {
        $processed = array_filter($this->data, $this->bindCallback($callback, $bindTo));

        return new self($processed);
    }

    /**
     * @return ArrayUtil
     */
    public function pop(): ArrayUtil {
        array_pop($this->data);

        return new self($this->toArray());
    }

    public function shift(): ArrayUtil {
        array_shift($this->data);

        return new self($this->toArray());
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array {
        return $this->toArray();
    }

    public function reverse(?bool $preserveKeys = null): ArrayUtil {
        return new self(array_reverse($this->toArray(), $preserveKeys));
    }
}
