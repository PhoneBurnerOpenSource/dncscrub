<?php


namespace PhoneBurner\DNCScrub\Result;


class F implements ResultCode, NumberCanNotBeCalledForTelemarketing, NumberCanNotBeCalledFromPredictiveDialer
{
    final public function getDescription(): string
    {
        return "Valid EBR and Wireless number in a US state that does not allow telemarketing to wireless numbers even if manually dialed not on any DNC list.";
    }
}