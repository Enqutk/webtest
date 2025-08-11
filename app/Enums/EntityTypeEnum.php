<?php

namespace App\Enums;

enum EntityTypeEnum: string 
{
    case client = 'client';
    case partner = 'partner';
    case award = 'award';
}
