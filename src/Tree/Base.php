<?php

namespace MCordingley\DecisionTree\Tree;

abstract class Base implements Node
{
    /** @var array */
    protected $branches = [];

    /** @var string */
    protected $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function setBranch(string $key, $value)
    {
        $this->branches[$key] = $value;
    }
}
