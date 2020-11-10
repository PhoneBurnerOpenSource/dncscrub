<?php


namespace PhoneBurner\DNCScrub\Result;


use ReflectionClass;

class G implements ResultCode, NumberCanNotBeCalledFromPredictiveDialer
{
    final public function getDescription(): string
    {
        return "Valid EBR and US Wireless Number or VoIP Number, not on any DNC database – still cannot be called from a predictive dialer as EBRs do not constitute an exemption to those rules.";
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}