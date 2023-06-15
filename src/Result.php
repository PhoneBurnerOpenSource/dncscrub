<?php

/**
 * Copyright 2023 PhoneBurner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

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

    private string $countryDNC;

    private string $stateDNC;

    private string $tpsDNC;

    private string $wirelessDetails;

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
    ) {
        [$country_dnc, $state_dnc, $tps_dnc, $wireless] = \explode(';', $reason) + [null, null, null, null];
        $this->phone = $phone;
        $this->resultCode = $resultCode;
        $this->date = $date;
        $this->reason = '';
        if ($country_dnc) {
            $this->reason .= $country_dnc;
        }

        $this->countryDNC = $country_dnc ?? "";
        $this->stateDNC = $state_dnc ?? "";
        $this->tpsDNC = $tps_dnc ?? "";
        $this->wirelessDetails = $wireless ?? "";
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
        $data = \str_getcsv($row);
        $result_factory = new ResultFactory();
        return new self(
            (string)$data[0],
            $result_factory->make((string)$data[1]),
            (string)$data[2],
            (string)$data[3],
            (string)$data[4],
            (string)$data[5],
            (string)$data[6],
            (string)$data[7],
            (string)$data[8],
            (string)$data[9],
            (string)$data[10],
            (string)$data[11],
            (string)$data[12],
            (string)$data[13],
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

    public function getCountryDNC(): string
    {
        return $this->countryDNC;
    }

    public function getStateDNC(): string
    {
        return $this->stateDNC;
    }

    public function getTpsDNC(): string
    {
        return $this->tpsDNC;
    }

    public function getWirelessDetails(): string
    {
        return $this->wirelessDetails;
    }
}
