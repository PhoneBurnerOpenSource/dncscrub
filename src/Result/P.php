<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class P implements ResultCode, NumberBlockedDoNotCall
{
    final public function getDescription(): string
    {
        return "Project DNC or DNF database match";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}