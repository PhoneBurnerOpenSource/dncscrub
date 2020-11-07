<?php


namespace PhoneBurner\DNCScrub\Result;


class W implements ResultCode, NumberCanNotBeCalledFromPredictiveDialer
{
    final public function getDescription(): string
    {
        return "US Wireless number – number is not in any DNC database (or it is but has been overridden by an industry exemption) but it cannot be called from a predictive dialer.";
    }
}