<?php

use App\Models\OTP;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedTinyInteger('status')->default(OTP::PENDING);
            $table->unsignedTinyInteger('sent_using')->default(1)->comment('1:all, 2:phone, 3:email');
            $table->nullableMorphs('otpable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
