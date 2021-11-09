<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RoyalMCPE\PCS\exceptions\ComponentException;

// TODO: abstract this so that plugins can create their own containers 
final class EntityContainer {

    private $entities = [];

    public function create(IComponent ...$defaultComponents): string {
        $uuid = Uuid::uuid4();
        $components = [];
        foreach($defaultComponents as $component) {
            $components[$component::class] = $component;
        }
        $this->entities[$uuid->getBytes()] = $components;
        return $uuid->getBytes();
    }

    public function isValid(string $uuid, bool $throw = false): bool {
        if(!array_key_exists($uuid, $this->entities)) {
            return $throw ? throw new InvalidArgumentException("Cannot apply changed to an entity that has been destroyed") : false;
        }
        return true;
    }

    public function destroy(string $uuid): void {
        if(!$this->isValid($uuid)) {
            throw new InvalidArgumentException("Cannot destroy an entity that has already been destroyed.");
        }
        unset($this->entities[$uuid]);
    }

    public function addComponent(string $uuid, IComponent $component): void {
        if(!$this->isValid($uuid)) {
            throw new InvalidArgumentException("Cannnot add a component for an entity that has been destroyed");
        }
        $this->entities[$uuid][$component::class] = $component;
    }

    public function hasComponent(string $uuid, string $componentType): bool {
        return array_key_exists($componentType, $this->entities[$uuid]);
    }

    public function removeComponent(string $uuid, string $componentType): void {
        if(!$this->isValid($uuid, true) || !$this->hasComponent($uuid, $componentType)) {
            throw new InvalidArgumentException("Cannot remove component {$componentType}");
        }
        unset($this->entities[$uuid][$componentType]);
    }

    public function filter(IFilter $filter): IFilterResult {
        return $filter->search($this->entities);
    }
}