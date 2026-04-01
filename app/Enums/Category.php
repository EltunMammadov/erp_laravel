<?php

namespace App\Enums;

enum Category: string
{
    case RawMaterial = 'raw_material';
    case FinishedGood = 'finished_good';
    case Service = 'service';
}