<?php

namespace MCordingley\DecisionTree\Nodes;

final class Enum extends Base
{
    public function test(array $example)
    {
        return $this->branches[$example[$this->key]] ?? null;
    }
}
