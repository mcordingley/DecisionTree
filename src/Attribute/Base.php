<?php

namespace MCordingley\DecisionTree\Attribute;

abstract class Base implements Attribute
{
    /** @var string */
    public $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }
}
