<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    const PENDING = 0;
    const VERIFIED = 1;


    protected $fillable = [
        'code',
        'status',
        'sent_using'
    ];

    public function otp()
    {
        return $this->morphTo();
    }
}
