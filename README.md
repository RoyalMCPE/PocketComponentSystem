## PocketComponentSystem

An EntityComponentSystem virion for PocketMine-MP that allows plugins to take a more data oriented approach.

## Usage
**WARNING**: None of this is set and stone and is subject to change. If you notice any discrepancy, please create a [issue](https://github.com/RoyalMCPE/PocketComponentSystem/issues/new).

In order to begin creating entities and handling their systems, we must first create a runtime to store our entities and handle our systems.

```php
use RoyalMCPE\PCS\Runtime;

$runtime = new Runtime();
```

## Creating a component
Components are ment to store data only. If your component has any functions a `RuntimeException` will be thrown. It is expected that you seperate data from logic to keep the data orientated specification in tact. 

```php
use RoyalMCPE\PCS\attributes;

#[Component]
class Position {
    public int $x;
    public int $y;
    public int $z;
}
```

## Creating an entity
Now that we have both a component and a runtime, we can now go ahead and create our first entity. On their own entities don't really do much, all they really are is just identifiers that the runtime uses to keep track of your data.

```php
/** @var Runtime $runtime */
$runtime->spawn()->insert(Position::create(mt_rand(0, 100), 0, 0));
```

## Create a system
Now that we have an entity created with our `Position` component, let's try and make it move.

```php
/** @var Runtime $runtime */
/** @var Plugin $this */
$logger = $this->getLogger();
$runtime->addSystem(
    SystemActivator::TASK(TaskType::REPEATING, 12),
    function() use($runtime, $logger){
        foreach($runtime->query(Position::class)->iter() as $entity, $component) {
            if($component->x % 15 == 0) { continue; }
            $component->x++;
            $logger->info("Entity: " + $entity + " has moved to: " + $component->x);
        }
});
```