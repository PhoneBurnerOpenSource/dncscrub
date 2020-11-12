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

    public function getResults(): array
    {
        return [
            new B(),
            new C(),
            new D(),
            new E(),
            new F(),
            new G(),
            new H(),
            new I(),
            new L(),
            new M(),
            new O(),
            new P(),
            new R(),
            new V(),
            new W(),
            new X(),
            new Y(),
        ];
    }
}