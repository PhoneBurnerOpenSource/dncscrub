<?php


namespace PhoneBurner\DNCScrub\Result;


class X implements ResultCode, NumberCanBeCalled
{
    final public function getDescription(): string
    {
        return "Industry eXemption applied to an otherwise Do Not Call number – number can be called";
    }
}