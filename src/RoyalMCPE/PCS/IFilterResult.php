<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS;

use Closure;

interface IFilterResult {

    function getResult(): array;
    function withCondition(Closure $condition): array;
}