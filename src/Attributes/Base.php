<?php

namespace MCordingley\DecisionTree\Attributes;

abstract class Base implements Attribute
{
    /** @var string */
    protected $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function key(): string
    {
        return $this->key;
    }
}
