<?php namespace PhoneBurner\DNCScrub\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public function __construct(ResponseInterface $response)
    {
    }
    //CSV Format
    //Phone #,ResultCode,DateField,Reason,RegionAbbrev,Country,Locale,CarrierInfo, NewReassignedAreaCode,tzCode,CallingWindow,UTCOffset,DoNotCallToday, CallingTimeRestrictions

}