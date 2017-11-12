<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Nodes\Boolean as BooleanNode;
use MCordingley\DecisionTree\Nodes\Node;

final class Boolean extends Base
{
    /**
     * @return Node
     */
    public function makeNode(): Node
    {
        return new BooleanNode($this->key);
    }

    /**
     * @param array $examples
     * @return array
     */
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
