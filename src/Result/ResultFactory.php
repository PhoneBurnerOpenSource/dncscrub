<?php

namespace PhoneBurner\DNCScrub\Result;

use FilesystemIterator;
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

    public function getPossibleResults(): array
    {
        $path = __DIR__;
        $classes = [];
        foreach (new FilesystemIterator($path) as $file) {
            $classname = '\\PhoneBurner\\DNCScrub\\Result\\' . $file->getBasename('.php');
            if (is_subclass_of($classname, ResultCode::class, true)) {
                $classes[] = new $classname;
            }
        }
        return $classes;
    }
}