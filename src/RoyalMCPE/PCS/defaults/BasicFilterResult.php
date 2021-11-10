<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS\defaults;

use Closure;
use pocketmine\utils\Utils;
use RoyalMCPE\PCS\IComponent;
use RoyalMCPE\PCS\IFilterResult;

class BasicFilterResult implements IFilterResult {

    public function __construct(private array $results) { }

    public function getResult(): array {
        return $this->results;
    }

    public function withCondition(Closure $condition): array {
        Utils::validateCallableSignature(function(string $uuid, IComponent $component): bool { return false; }, $condition);
        $results = [];
        foreach($this->results as $uuid => $component) {
            if(($condition)($uuid, $component)) {
                $results[] = $uuid;
            }
        }
        return $results;
    }
}