<?php

namespace MCordingley\DecisionTree\Nodes;

final class Enum extends Base
{
    public function classify(array $example)
    {
        $branch = $this->branches[$example[$this->key]] ?? null;

        return $branch instanceof Node ? $branch->classify($example) : $branch;
    }
}
