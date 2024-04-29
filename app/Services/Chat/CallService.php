<?php

namespace App\Services\Chat;

use App\Services\Chat\RtcTokenBuilder2;



class CallService
{

    public static function agoraToken($user_id, $channelName)
    {
        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');


        return RtcTokenBuilder2::buildTokenWithUid($appID, $appCertificate, $channelName, 0, RtcTokenBuilder2::ROLE_PUBLISHER, (now()->getTimestamp() + 3600));

    }
}
