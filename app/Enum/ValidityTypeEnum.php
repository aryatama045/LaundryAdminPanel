<?php

namespace App\Enum;

enum ValidityTypeEnum: string
{
    case DAY = 'days';
    case MONTH = 'months';
    case YEAR = 'years';
}
