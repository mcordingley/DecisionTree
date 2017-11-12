<?php

namespace MCordingley\DecisionTree\Nodes;

final class Boolean extends Base
{
    public function classify(array $example)
    {
        $branch = $this->branches[$example[$this->key] ? 1 : 0] ?? null;

        return $branch instanceof Node ? $branch->classify($example) : $branch;
    }
}
