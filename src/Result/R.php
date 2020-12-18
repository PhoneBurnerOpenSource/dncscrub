<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class R implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "expiRed ebr - number used to be a valid EBR, not on a Do Not Call list – number can be called";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}