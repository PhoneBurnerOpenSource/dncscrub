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

final class B implements ResultCode, NumberCanNotBeCalled
{
    public function getDescription(): string
    {
        return "Blocked (number is in an area code not covered by the National Subscription on this project or is in a configured no-call area code or no exemption was available in a pre-recorded call campaign)";
    }

    public function __toString(): string
    {
        return 'B';
    }
}
