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
                'en' => 'IT 💻',
                'ar' => 'تكنولوجيا المعلومات 💻'
            ],
            [
                'en' => 'Marketing 🛍️',
                'ar' => 'التسويق 🛍️'
            ],
            [
                'en' => 'Design',
                'ar' => 'التصميم'
            ],
            [
                'en' => 'Business',
                'ar' => 'الأعمال',
            ],
            [
                'en' => 'Finance',
                'ar' => 'التمويل',
            ],
            [
                'en' => 'Healthcare',
                'ar' => 'الرعاية الصحية',
            ],
            [
                'en' => 'Education',
                'ar' => 'التعليم',
            ],
            [
                'en' => 'Law',
                'ar' => 'القانون',
            ],
            [
                'en' => 'Government',
                'ar' => 'الحكومة',
            ],
            [
                'en' => 'Non-profit',
                'ar' => 'المنظمات غير الربحية',
            ],
            [
                'en' => 'Arts',
                'ar' => 'الآداب',
            ],
            [
                'en' => 'Music',
                'ar' => 'الموسيقى',
            ],
            [
                'en' => 'Sports',
                'ar' => 'الرياضة',
            ],
            [
                'en' => 'Travel',
                'ar' => 'السفر',
            ],
            [
                'en' => 'Food',
                'ar' => 'الطعام',
            ],
            [
                'en' => 'Fashion',
                'ar' => 'الأزياء',
            ],
            [
                'en' => 'Beauty',
                'ar' => 'الجمال',
            ],
            [
                'en' => 'Home',
                'ar' => 'المنزل',
            ],
            [
                'en' => 'Family',
                'ar' => 'العائلة',
            ],
            [
                'en' => 'Friends',
                'ar' => 'الأصدقاء',
            ],
            [
                'en' => 'Pets',
                'ar' => 'الحيوانات الأليفة',
            ],
            [
                'en' => 'Humor',
                'ar' => 'الفكاهة',
            ],
            [
                'en' => 'Gaming',
                'ar' => 'الألعاب',
            ],
            [
                'en' => 'Technology',
                'ar' => 'التكنولوجيا',
            ],
            [
                'en' => 'Science',
                'ar' => 'العلوم',
            ],
            [
                'en' => 'History',
                'ar' => 'التاريخ',
            ],
            [
                'en' => 'Politics',
                'ar' => 'السياسة',
            ],
            [
                'en' => 'Current events',
                'ar' => 'الأحداث الجارية',
            ],
            [
                'en' => 'Culture',
                'ar' => 'الثقافة',
            ],
            [
                'en' => 'Religion',
                'ar' => 'الدين',
            ],
            [
                'en' => 'Spirituality',
                'ar' => 'الروحانيات',
            ],
            [
                'en' => 'Environment',
                'ar' => 'البيئة',
            ],
            [
                'en' => 'Animals',
                'ar' => 'الحيوانات',
            ],
            [
                'en' => 'Nature',
                'ar' => 'الطبيعة',
            ],
            [
                'en' => 'Travel',
                'ar' => 'السفر',
            ],
            [
                'en' => 'Food',
                'ar' => 'الطعام',
            ],
            [
                'en' => 'Photography',
                'ar' => 'التصوير الفوتوغرافي',
            ],
            [
                'en' => 'Art',
                'ar' => 'الفن',
            ],
            [
                'en' => 'Personal development',
                'ar' => 'التطوير الشخصي',
            ],
            [
                'en' => 'Self-care',
                'ar' => 'العناية الذاتية',
            ],
            [
                'en' => 'Reading',
                'ar' => 'القراءة',
            ]
        ];

        foreach ($interests as $interest) {
            Interest::create([
                'name' => $interest
            ]);
        }
    }
}
