<?php

namespace App\Services\Notification;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class NotificationSender
{
    public const ALL = 1;
    public const SMS = 2;
    public const EMAIL = 3;

    public function __construct(protected User|Authenticatable $user, protected int $type = 1, protected string|null $subject = null, protected string|null $content = null)
    {

    }
    public static function send(User|Authenticatable $user, int $type = 1, string|null $subject = null, string|null $content = null)
    {
        # type-> 1:Send by email, 2:Send by sms, 3:Send by all
        return (new self($user, $type, $subject))->sendNotification();
    }

    protected function sendNotification()
    {
        try {

            return match ($this->type) {
                1 => function () {
                        $this->sendEmail();
                        $this->sendSms();
                    },
                2 => $this->sendSms(),
                3 => $this->sendEmail(),
                default => throw new \Exception("Invalid type"),
            };

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    protected function sendEmail()
    {
        // return Mail::to($this->user->email)->send(new OtpEmail($this->user, $this->generatedOtp->code, $this->subject));
    }

    protected function sendSms()
    {
        // return true;
    }

}
