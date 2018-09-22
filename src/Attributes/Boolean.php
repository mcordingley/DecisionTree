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
        $groups = [
            0 => [],
            1 => [],
        ];

        foreach ($examples as $item) {
            $groups[$item[$this->key] ? 1 : 0][] = $item;
        }

        return $groups;
    }
}
