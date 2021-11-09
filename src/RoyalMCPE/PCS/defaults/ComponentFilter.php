<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS\defaults;

use RoyalMCPE\PCS\IFilter;
use RoyalMCPE\PCS\IFilterResult;

/**
 * Search for an entity based on what components they have.
 */
final class ComponentFilter implements IFilter {

    public function __construct(private string $componentType) { }

    public function search(array $entities): IFilterResult {
        $results = [];
        foreach($entities as $uuid => $components) {
            if(array_key_exists($this->componentType, $components)) {
                $results[$uuid] = $components[$this->componentType];
            }
        }
        $result = new BasicFilterResult($results);
        return $result;
    }
}