<?php


namespace PhoneBurner\DNCScrub\Result;


class D implements ResultCode, NumberBlockedDoNotCall
{
    final public function getDescription(): string
    {
        return "Do not call database match";
    }
}