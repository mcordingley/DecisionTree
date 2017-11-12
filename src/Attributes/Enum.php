<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Tree\Enum as EnumNode;
use MCordingley\DecisionTree\Tree\Node;

final class Enum extends Base
{
    /**
     * @return Node
     */
    public function makeNode(): Node
    {
        return new EnumNode($this->key);
    }

    /**
     * @param array $examples
     * @return array
     */
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
