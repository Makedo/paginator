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
     * @var Traversable
     */
    private $iterator;

    /**
     * @var int
     */
    private $count;

    public function __construct(Traversable $items, int $count)
    {
        $this->iterator = $items;
        $this->count = $count;
    }

    public static function fromIterable(iterable $items): self
    {
        if (is_array($items)) {
            return self::fromArray($items);
        }

        if ($items instanceof Traversable) {
            return self::fromTraversable($items);
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

    public static function fromTraversable(Traversable $items): self
    {
        $count = self::countItems($items);
        return new self($items, $count);
    }

    public function getIterator(): Traversable
    {
        return $this->iterator;
    }

    public function count(): int
    {
        return $this->count;
    }

    private static function countItems(Traversable $items): int
    {
        if ($items instanceof Countable) {
            $count = $items->count();
        } else {
            $count = 0;
            foreach ($items as $v) {
                ++$count;
            }
            if ($items instanceof Iterator) {
                $items->rewind();
            }
        }

        return $count;
    }
}
