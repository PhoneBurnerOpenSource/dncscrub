<?php

namespace PhoneBurner\DNCScrub\Result;

use ReflectionClass;

class D implements ResultCode, NumberBlockedDoNotCall
{
    final public function getDescription(): string
    {
        return "Do not call database match";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}