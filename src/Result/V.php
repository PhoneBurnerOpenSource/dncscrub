<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class V implements ResultCode, NumberCanNotBeCalledForTelemarketing
{
    final public function getDescription(): string
    {
        return "Valid EBR overriding otherwise DNC number that is also a Wireless number in a US state that does not allow telemarketing to wireless numbers even if manually dialed (These states are WY, NJ, TX, LA, and AZ.)";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}