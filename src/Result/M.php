<?php


namespace PhoneBurner\DNCScrub\Result;


class M implements ResultCode, NumberCanNotBeCalled
{
    final public function getDescription(): string
    {
        return "Malformed (number is not 10 digits)";
    }
}