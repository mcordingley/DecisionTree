<?php

namespace MCordingley\DecisionTree\Nodes;

use MCordingley\DecisionTree\Node;

final class Continuous extends Base
{
    public function classify(array $example)
    {
        $keys = array_keys($this->branches);
        $splitPoint = end($keys);
        $branch = $this->branches[$example[$this->key] >= $splitPoint ? $splitPoint : ''];

        return $branch instanceof Node ? $branch->classify($example) : $branch;
    }
}
