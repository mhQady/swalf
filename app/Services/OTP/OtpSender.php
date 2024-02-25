<?php

namespace App\Services\OTP;

use App\Models\User;
use App\Services\Notification\NotificationSender;
use Illuminate\Contracts\Auth\Authenticatable;

class OtpSender
{
    protected $generatedOtp;
    public function __construct(protected User|Authenticatable $user, protected int $type = 1, protected string|null $subject = null)
    {

    }
    public static function send(User|Authenticatable $user, int $type = 1, string|null $subject = null)
    {
        # type-> 1:Send by all, 2:Send by sms, 3:Send email
        return (new self($user, $type, $subject))->sendOtp();
    }

    protected function sendOtp()
    {
        try {

            $this->generateNumericOTP();

            return NotificationSender::send($this->user, $this->type, $this->subject, $this->generatedOtp->code);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    protected function generateNumericOTP($n = 4): void
    {
        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, rand() % strlen($generator), 1);
        }

        if (!app()->environment('production'))
            $result = 11111;


        $this->user->allOtp()->delete();

        $this->generatedOtp = $this->user->allOtp()->create([
            'code' => $result,
            'type' => $this->type,
        ]);
    }
}
