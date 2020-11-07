<?php


namespace PhoneBurner\DNCScrub;


use PhoneBurner\DNCScrub\Result\ResultCode;
use PhoneBurner\DNCScrub\Result\ResultFactory;

class Result
{
    private ResultCode $resultCode;
    private string $date;
    private string $reason;
    private string $region;
    private string $country;
    private string $locale;
    private string $carrier;
    private string $newReassignedAreaCode;
    private string $timeZoneCode;
    private string $callingWindow;
    private string $utcOffset;
    private string $doNotCallToday;
    private string $callingTimeRestrictions;
    private string $phone;

    private function __construct(
        string $phone,
        ResultCode $resultCode,
        string $date,
        string $reason,
        string $region,
        string $country,
        string $locale,
        string $carrier,
        string $newReassignedAreaCode,
        string $timeZoneCode,
        string $callingWindow,
        string $utcOffset,
        string $doNotCallToday,
        string $callingTimeRestrictions
    )
    {
        $this->phone = $phone;
        $this->resultCode = $resultCode;
        $this->date = $date;
        $this->reason = $reason;
        $this->region = $region;
        $this->country = $country;
        $this->locale = $locale;
        $this->carrier = $carrier;
        $this->newReassignedAreaCode = $newReassignedAreaCode;
        $this->timeZoneCode = $timeZoneCode;
        $this->callingWindow = $callingWindow;
        $this->utcOffset = $utcOffset;
        $this->doNotCallToday = $doNotCallToday;
        $this->callingTimeRestrictions = $callingTimeRestrictions;
    }

    public static function fromCSV(string $row): self
    {
        $data = str_getcsv($row);
        $result_factory = new ResultFactory();
        return new self(
            $data[0],
            $result_factory->make($data[1]),
            $data[2],
            $data[3],
            $data[4],
            $data[5],
            $data[6],
            $data[7],
            $data[8],
            $data[9],
            $data[10],
            $data[11],
            $data[12],
            $data[13],
        );
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getResultCode(): ResultCode
    {
        return $this->resultCode;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getNewReassignedAreaCode(): string
    {
        return $this->newReassignedAreaCode;
    }

    public function getTimeZoneCode(): string
    {
        return $this->timeZoneCode;
    }

    public function getCallingWindow(): string
    {
        return $this->callingWindow;
    }

    public function getUtcOffset(): string
    {
        return $this->utcOffset;
    }

    public function getDoNotCallToday(): string
    {
        return $this->doNotCallToday;
    }

    public function getCallingTimeRestrictions(): string
    {
        return $this->callingTimeRestrictions;
    }
}