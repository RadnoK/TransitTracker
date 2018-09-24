<?php

declare(strict_types=1);

namespace TransitTracker\Infrastructure\Prooph;

use Prooph\Common\Messaging\Message;

trait ApplyMethodDispatcherTrait
{
    protected function apply(Message $event): void
    {
        $eventClass = get_class($event);
        $applyMethodName = strtolower('apply' . substr($eventClass, strrpos($eventClass, '\\') + 1));
        $applyMethodNames = array_map(
            function (string $class): string {
                return strtolower($class);
            },
            get_class_methods(static::class)
        );

        if (!in_array($applyMethodName, $applyMethodNames, true)) {
            return;
        }

        $this->$applyMethodName($event);
    }
}

