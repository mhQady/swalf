<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\User\CompleteDataEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Osama',
            'phone' => '512345678',
            'email' => 'osame@swalf.com',
            'password' => 'Zero@1280',
            'complete_data' => CompleteDataEnum::PASSWORD_ENTERED
        ]);

        User::factory(100)->create();
    }
}
