<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class Y implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "VoIP number not in any DNC databases (or it has been overridden by an industry exemption).";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}