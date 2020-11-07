<?php


namespace PhoneBurner\DNCScrub\Result;


class P implements ResultCode, NumberBlockedDoNotCall
{
    final public function getDescription(): string
    {
        return "Project DNC or DNF database match";
    }
}