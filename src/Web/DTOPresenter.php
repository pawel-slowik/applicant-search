<?php

declare(strict_types=1);

namespace Recruitment\Web;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

class DTOPresenter
{
    // don't feel like writing specialized presenters
    public function present($input)
    {
        if (is_scalar($input)) {
            return $input;
        }
        if (is_array($input)) {
            return array_map([$this, 'present'], $input);
        }
        if (is_object($input)) {
            return $this->presentObject($input);
        }
        throw new InvalidArgumentException();
    }

    private function presentObject(object $object)
    {
        if (method_exists($object, '__toString')) {
            return (string) $object;
        }

        $properties = [];

        foreach ($this->listGetters($object) as $getter) {
            $key = $this->keyFromGetterName($getter->getName());
            $value = $this->present($getter->invoke($object));
            $properties[$key] = $value;
        }

        return $properties;
    }

    private function listGetters(object $object): array
    {
        // could be cached if needed
        return array_filter(
            (new ReflectionClass($object))->getMethods(),
            static function (ReflectionMethod $method): bool {
                return $method->isPublic() && 'get' === substr($method->getName(), 0, 3);
            }
        );
    }

    private function keyFromGetterName(string $getterName): string
    {
        return lcfirst(substr($getterName, 3));
    }
}
