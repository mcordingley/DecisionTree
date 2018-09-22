<?php

namespace MCordingley\DecisionTree\Nodes;

use MCordingley\DecisionTree\Node;

abstract class Base implements Node
{
    protected $branches = [];
    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function setBranch(string $key, $value): void
    {
        $this->branches[$key] = $value;
    }
}
