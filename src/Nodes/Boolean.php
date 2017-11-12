<?php

namespace MCordingley\DecisionTree\Nodes;

final class Boolean extends Base
{
    public function test(array $example)
    {
        return $this->branches[$example[$this->key] ? 1 : 0] ?? null;
    }
}
