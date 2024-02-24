<?php

use App\Enums\User\CompleteDataEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('complete_data')->default(CompleteDataEnum::NONE->value);
            $table->string('phone_code')->default('966');
            $table->string('phone')->unique();
            $table->string('name')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('email')->unique()->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            // $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
