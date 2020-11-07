<?php


namespace PhoneBurner\DNCScrub\Result;


class O implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "ebr Override was applied to an otherwise Do Not Call number (including an explicit EBR
overriding a number in Project DNC) – number can be called";
    }
}