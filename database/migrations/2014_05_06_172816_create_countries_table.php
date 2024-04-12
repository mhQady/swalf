<?php

use App\Enums\Country\StatusEnum;
use App\Enums\Country\HasMarketEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('phone_code');
            $table->boolean('is_active')->default(StatusEnum::ACTIVE->value);
            $table->boolean('has_market')->default(HasMarketEnum::NO->value);
            $table->string('currency_code')->nullable();
        });
    }


    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
