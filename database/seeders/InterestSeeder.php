<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            [
                'en' => 'Vehicles ',
                'ar' => 'مركبات '
            ],
            [
                'en' => 'Mobiles ',
                'ar' => 'هواتف نقالة '
            ],
            [
                'en' => 'Electronics ',
                'ar' => 'الالكترونيات '
            ],
            [
                'en' => 'Fashion (Men) ',
                'ar' => 'الأزياء (رجالي) '
            ],
            [
                'en' => 'Fashion (Women) ',
                'ar' => 'الأزياء (نسائي) '
            ],
            [
                'en' => 'Home & Garden ',
                'ar' => 'المنزل والحديقة '
            ],
            [
                'en' => 'Health & Beauty ',
                'ar' => 'الصحة والجمال '
            ],
            [
                'en' => 'Sports & Outdoors ⚽',
                'ar' => 'الرياضة والهواء الطلق ⚽'
            ],
            [
                'en' => 'Toys & Games ',
                'ar' => 'الألعاب '
            ],
            [
                'en' => 'Books & Music ',
                'ar' => 'الكتب والموسيقى '
            ],
            [
                'en' => 'Grocery & Drinks ',
                'ar' => 'البقالة والمشروبات '
            ],
            [
                'en' => 'Baby & Kids ',
                'ar' => 'الأطفال '
            ],
            [
                'en' => 'Pet Supplies ',
                'ar' => 'مستلزمات الحيوانات الأليفة '
            ],
            [
                'en' => 'Furniture ️',
                'ar' => 'الأثاث ️'
            ],
            [
                'en' => 'Appliances 冰箱',
                'ar' => 'الأجهزة المنزلية 冰箱'
            ],
            [
                'en' => 'DIY & Tools ',
                'ar' => 'الادوات واللوازم '
            ],
            [
                'en' => 'Jewelry & Watches ',
                'ar' => 'المجوهرات والساعات '
            ],
            [
                'en' => 'Arts & Crafts ',
                'ar' => 'الفنون والحرف اليدوية '
            ],
            [
                'en' => 'Office Supplies ',
                'ar' => 'اللوازم المكتبية '
            ],
            [
                'en' => 'Party Supplies ',
                'ar' => 'مستلزمات الحفلات '
            ],
            [
                'en' => 'Travel & Luggage ✈️',
                'ar' => 'السفر والأمتعة ✈️'
            ],
            [
                'en' => 'Movies & TV Shows ',
                'ar' => 'الأفلام والبرامج التلفزيونية '
            ],
            [
                'en' => 'Video Games & Consoles ',
                'ar' => 'ألعاب الفيديو ووحدات التحكم '
            ],
            [
                'en' => 'Musical Instruments ',
                'ar' => 'الآلات الموسيقية '
            ],
            [
                'en' => 'Beauty Tools & Accessories ',
                'ar' => 'أدوات واكسسوارات التجميل '
            ],
            [
                'en' => 'Fragrances & Perfumes ',
                'ar' => 'العطور والعطور '
            ],
            [
                'en' => 'Stationery & Writing Supplies ️',
                'ar' => 'القرطاسية ومستلزمات الكتابة ️'
            ],
            [
                'en' => 'Sportswear & Activewear ️‍♀️',
                'ar' => 'ملابس رياضية وملابس رياضية ️‍♀️'
            ]
        ];

        foreach ($interests as $interest) {
            Interest::create([
                'name' => $interest
            ]);
        }
    }
}
