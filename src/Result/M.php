<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class M implements ResultCode, NumberCanNotBeCalled
{
    final public function getDescription(): string
    {
        return "Malformed (number is not 10 digits)";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}