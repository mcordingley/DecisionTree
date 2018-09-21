<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Attribute;

abstract class Base implements Attribute
{
    /** @var string */
    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function key(): string
    {
        return $this->key;
    }
}
