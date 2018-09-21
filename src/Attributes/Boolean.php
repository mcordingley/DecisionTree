<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Node;
use MCordingley\DecisionTree\Nodes\Boolean as BooleanNode;

final class Boolean extends Base
{
    public function makeNode(): Node
    {
        return new BooleanNode($this->key);
    }

    public function partition(array $examples): array
    {
        $groups = [];

        foreach ($examples as $item) {
            $keyValue = $item[$this->key] ? 1 : 0;

            if (!isset($groups[$keyValue])) {
                $groups[$keyValue] = [];
            }

            $groups[$keyValue][] = $item;
        }

        return $groups;
    }
}
