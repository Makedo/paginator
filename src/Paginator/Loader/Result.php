<?php

namespace Makedo\Paginator\Loader;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use LimitIterator;

final class Result implements IteratorAggregate, Countable
{
    /**
     * @var Iterator
     */
    private $items;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int
     */
    private $count;

    public function __construct(Iterator $items, ?int $limit = null, ?int $count = null)
    {
        $this->items = $items;
        $this->limit = $limit;
        $this->count = $count;
    }

    public static function fromIterable(iterable $items, ?int $limit = null): self
    {
        if (is_array($items)) {
            return self::fromArray($items, $limit);
        }

        if ($items instanceof Iterator) {
            return self::fromIterator($items, $limit);
        }

        throw new InvalidArgumentException('Items should be array or \Iterator');
    }

    public static function fromArray(array $items, ?int $limit = null): self
    {
        return new self(new ArrayIterator($items), $limit);
    }

    public static function fromIterator(Iterator $items, ?int $limit = null): self
    {
        return new self($items, $limit);
    }

    public function getIterator(): Iterator
    {
        return $this->limit
            ? new LimitIterator($this->items, 0, $this->limit)
            : $this->items
        ;
    }

    public function count(): int
    {
        if (null === $this->count) {
            $this->count = self::countItems($this->items);
        }

        return $this->count;
    }

    private static function countItems(Iterator $items): int
    {
        if ($items instanceof Countable) {
            $count = $items->count();
        } else {
            $count = 0;
            foreach ($items as $v) {
                ++$count;
            }
            $items->rewind();
        }

        return $count;
    }
}
