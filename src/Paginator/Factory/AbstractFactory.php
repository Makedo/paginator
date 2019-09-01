<?php


namespace Makedo\Paginator\Factory;


abstract class AbstractFactory
{
    const DEFAULT_PER_PAGE = 10;

    protected $perPage;

    public function __construct(int $perPage = self::DEFAULT_PER_PAGE)
    {
        $this->perPage = $this->filterLessOrEqualZero($perPage, self::DEFAULT_PER_PAGE);
    }

    public function withPerPage(int $perPage): AbstractFactory
    {
        return new static($perPage);
    }

    protected function filterLessOrEqualZero(int $value, int $default = 1): int
    {
        if ($value <= 0) {
            return $default;
        }

        return $value;
    }
}
