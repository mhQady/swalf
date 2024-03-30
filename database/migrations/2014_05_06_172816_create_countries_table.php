<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('phone_code');
            $table->boolean('is_active')->default(1);
            $table->boolean('has_market')->default(0);
            $table->string('currency_code')->nullable();
        });
    }


    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
