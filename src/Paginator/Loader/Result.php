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
    private $iterator;

    /**
     * @var int
     */
    private $count;

    public function __construct(Iterator $items, ?int $count = null, ?int $limit = null)
    {
        $this->iterator = $limit ? new LimitIterator($items, 0, $limit) : $items;
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
        return new self(
            new ArrayIterator($items),
            count($items),
            $limit
        );
    }

    public static function fromIterator(Iterator $items, ?int $limit = null): self
    {
        $count = self::countItems($items);
        return new self($items, $count, $limit);
    }

    public function getIterator(): Iterator
    {
        return $this->iterator;
    }

    public function count(): int
    {
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
