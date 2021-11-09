<?php

declare(strict_types = 1);

namespace RoyalMCPE\PCS;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

// TODO: abstract this so that plugins can create their own containers 
final class EntityContainer {

    private $entities = [];

    // TODO: Allow for plugins to define default components for entities
    public function create(): string {
        $uuid = Uuid::uuid4();
        $this->entities[$uuid->getBytes()] = [];
        return $uuid->getBytes();
    }

    public function destroy(string $uuid): void {
        if(!array_key_exists($uuid, $this->entities)) {
            throw new InvalidArgumentException("Cannot destroy an entity that has already been destroyed.");
        }
        unset($this->entities[$uuid]);
    }
}