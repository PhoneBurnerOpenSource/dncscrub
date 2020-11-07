<?php


namespace PhoneBurner\DNCScrub\Result;


class I implements ResultCode, NumberCanNotBeCalled
{
    final public function getDescription(): string
    {
        return "Invalid (area code not active or reserved/special use phone number pattern (i.e. 555-5555))";
    }
}