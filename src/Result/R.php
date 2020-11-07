<?php


namespace PhoneBurner\DNCScrub\Result;


class R implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "expiRed ebr - number used to be a valid EBR, not on a Do Not Call list – number can be
called";
    }
}