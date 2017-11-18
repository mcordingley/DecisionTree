<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Nodes\Enum as EnumNode;
use MCordingley\DecisionTree\Nodes\Node;

final class Enum extends Base
{
    public function makeNode(): Node
    {
        return new EnumNode($this->key);
    }

    public function partition(array $examples): array
    {
        $groups = [];

        foreach ($examples as $item) {
            $keyValue = $item[$this->key];

            if (!isset($groups[$keyValue])) {
                $groups[$keyValue] = [];
            }

            $groups[$keyValue][] = $item;
        }

        return $groups;
    }
}
