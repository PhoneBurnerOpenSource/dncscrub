<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class I implements ResultCode, NumberCanNotBeCalled
{
    final public function getDescription(): string
    {
        return "Invalid (area code not active or reserved/special use phone number pattern (i.e. 555-5555))";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}