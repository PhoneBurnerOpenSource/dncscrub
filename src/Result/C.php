<?php


namespace PhoneBurner\DNCScrub\Result;


class C implements ResultCode, NumberCanBeCalled
{

    final public function getDescription(): string
    {
        return "Clean, number can be called";
    }
}