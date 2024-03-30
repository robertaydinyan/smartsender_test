<?php

namespace App\Constants;

class FormOptions
{
    public const MESSAGE_OPTIONS = [
        '' => '',
        0 => 'email',
        1 => 'sms',
        2 => 'webpush',
        3 => 'telegram',
        4 => 'viber'
    ];
}
