<?php

namespace App\Enums;

enum EntityTypeEnum: string {
    case Client = 'client';
    case Partner = 'partner';
    case Award = 'award';
}