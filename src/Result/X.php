<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class X implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "Industry eXemption applied to an otherwise Do Not Call number – number can be called";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}