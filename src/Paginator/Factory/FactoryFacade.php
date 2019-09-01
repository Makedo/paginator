<?php

namespace Makedo\Paginator\Factory;

class FactoryFacade
{
    public function createSkipById(int $perPage): SkipById
    {
        return new SkipById($perPage);
    }

    public function createSkipByIdWithCount(int $perPage): SkipByIdCountable
    {
        return new SkipByIdCountable($perPage);
    }

    public function createSkipByIdWithCountAndCurrentPage(
        int $perPage
    ): SkipByIdCountableWithCurrentPage
    {
        return new SkipByIdCountableWithCurrentPage($perPage);
    }

    public function createSkipByOffset(int $perPage): SkipByOffset
    {
        return new SkipByOffset($perPage);
    }

    public function createSkipByOffsetWithCount(
        int $perPage
    ): SkipByOffsetCountable
    {
        return new SkipByOffsetCountable($perPage);
    }
}