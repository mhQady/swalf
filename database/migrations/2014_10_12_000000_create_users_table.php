<?php

use App\Enums\User\CompleteDataEnum;
use App\Enums\User\GenderEnum;
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
            $table->string('phone')->unique()->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->unsignedTinyInteger('gender')->default(GenderEnum::MALE->value);
            $table->date('birth_date')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->text('about')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('change_password_requested_at')->nullable();
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
