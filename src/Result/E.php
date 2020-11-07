<?php


namespace PhoneBurner\DNCScrub\Result;


class E implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "Ebr – currently valid, not on a Do Not Call list";
    }
}