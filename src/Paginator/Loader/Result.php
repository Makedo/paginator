<?php

namespace Makedo\Paginator\Loader;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use Traversable;

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

    public function __construct(Iterator $items, int $count)
    {
        $this->iterator = $items;
        $this->count = $count;
    }

    public static function fromIterable(iterable $items): self
    {
        if (is_array($items)) {
            return self::fromArray($items);
        }

        if ($items instanceof Iterator) {
            return self::fromIterator($items);
        }

        throw new InvalidArgumentException('Items should be array or Traversable');
    }

    public static function fromArray(array $items): self
    {
        return new self(
            new ArrayIterator($items),
            count($items)
        );
    }

    public static function fromIterator(Iterator $items): self
    {
        $count = self::countItems($items);
        return new self($items, $count);
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
