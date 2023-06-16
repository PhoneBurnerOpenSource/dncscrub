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

namespace PhoneBurner\DNCScrub\Result;

final class H implements ResultCode, NumberCanNotBeCalledFromPredictiveDialer
{
    public function getDescription(): string
    {
        return "US Wireless Number or VoIP Number that is also a Valid EBR overriding an otherwise DNC number – still cannot be called from a predictive dialer as EBRs do not constitute an exemption to those rules.";
    }

    public function __toString(): string
    {
        return 'H';
    }
}
