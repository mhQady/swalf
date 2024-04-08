<?php

return [

    'OTP_EXPIRY' => env('OTP_EXPIRY', 3), # in minutes

    'CHANGE_PASSWORD_EXPIRY' => env('CHANGE_PASSWORD_EXPIRY', 3), # in minutes

    'AGORA_APP_ID' => env('AGORA_APP_ID', '690092f3796b42399091c416c2aa71c6'),

    'AGORA_APP_CERTIFICATE' => env('AGORA_APP_CERTIFICATE', '0c0b908f35874bcfbdf91041720c3b24'),
];
