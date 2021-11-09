<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS;

interface IFilter {

    function search(array $entities): IFilterResult;
}