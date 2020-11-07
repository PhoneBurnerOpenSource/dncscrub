<?php

namespace PhoneBurner\DNCScrub\Result;

interface ResultCode
{
    public function getDescription(): string;
}