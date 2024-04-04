<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'ar' => 'معلومات المُنتج غير صحيحة',
                'en' => 'Incorrect Product Information'
            ],
            [
                'ar' => 'لم يصل المنتج أو وصل تالفًا.',
                'en' => 'Product Did Not Arrive or Arrived Damaged'
            ],
            [
                'ar' => 'الوصف أو الصور أو المواصفات لا تتطابق مع المنتج الفعلي.',
                'en' => 'Description, Images, or Specifications Do Not Match Product'
            ],
            [
                'ar' => 'المنتج يبدو أنه مقلد أو غير أصلي.',
                'en' => 'Product Appears to Be Counterfeit'
            ],
            [
                'ar' => 'المنتج معروض بسعر أعلى بكثير من القيمة السوقية المتوقعة.',
                'en' => 'Product Listed at Significantly Exorbitant Price'
            ],
        ];

        foreach ($types as $type) {
            \App\Models\ReportType::create(['name' => $type]);
        }
    }
}
