<?php

namespace PhoneBurner\DNCScrub\Result;

use RuntimeException;

class ResultFactory
{
    public function make(string $status): ResultCode
    {
        $class = 'PhoneBurner\\DNCScrub\\Result\\' . $status;
        if (class_exists($class)) {
            return new $class();
        }

        throw new RuntimeException('Invalid Result: ' . $status);
    }
}