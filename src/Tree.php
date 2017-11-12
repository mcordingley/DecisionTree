<?php

namespace MCordingley\DecisionTree;

use MCordingley\DecisionTree\Tree\Node;

final class Tree
{
    /** @var Node|mixed */
    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function test($example)
    {
        $node = $this->root;

        while ($node instanceof Node) {
            $node = $node->test($example);
        }

        return $node;
    }
}
