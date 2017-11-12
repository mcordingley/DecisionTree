<?php

namespace MCordingley\DecisionTree\Tree;

final class Enum extends Base
{
    public function test(array $example)
    {
        return $this->branches[$example[$this->key]] ?? null;
    }
}
