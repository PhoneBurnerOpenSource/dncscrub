<?php

namespace PhoneBurner\DNCScrub\Result;

use ReflectionClass;

class C implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "Clean, number can be called";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}