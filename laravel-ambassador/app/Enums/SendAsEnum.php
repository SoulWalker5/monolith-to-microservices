<?php

namespace App\Enums;

enum SendAsEnum: string
{
    case Json = 'asJson';
    case From = 'asForm';
}
