<?php

namespace PhoneBurner\DNCScrub\Result;

use ReflectionClass;

class B implements ResultCode, NumberCanNotBeCalled
{
    final public function getDescription(): string
    {
        return "Blocked (number is in an area code not covered by the National Subscription on this project or is in a configured no-call area code or no exemption was available in a pre-recorded call campaign)";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}