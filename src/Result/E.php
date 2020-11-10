<?php

namespace PhoneBurner\DNCScrub\Result;

use ReflectionClass;

class E implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "Ebr – currently valid, not on a Do Not Call list";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}