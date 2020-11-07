<?php


namespace PhoneBurner\DNCScrub\Result;


class H implements ResultCode, NumberCanNotBeCalledFromPredictiveDialer
{
    final public function getDescription(): string
    {
        return "US Wireless Number or VoIP Number that is also a Valid EBR overriding an otherwise DNC number – still cannot be called from a predictive dialer as EBRs do not constitute an exemption to those rules.";
    }
}