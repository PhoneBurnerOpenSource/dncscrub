<?php


namespace PhoneBurner\DNCScrub\Result;


class L implements ResultCode, NumberCanNotBeCalledForTelemarketing, NumberCanNotBeCalledFromPredictiveDialer
{
    final public function getDescription(): string
    {
        return "Wireless number in a US state that does not allow telemarketing to wireless numbers even if manually dialed not on any DNC list; not an EBR.";
    }
}