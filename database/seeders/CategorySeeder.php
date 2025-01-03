<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Akıllı telefonlardan dizüstü bilgisayarlara, en son teknoloji ürünlerini burada bulabilirsiniz.',
            ],
            [
                'name' => 'Moda ve Giyim',
                'description' => 'Kadın, erkek ve çocuklar için en şık kıyafetler ve aksesuarlar.',
            ],
            [
                'name' => 'Ev ve Yaşam',
                'description' => 'Dekorasyon ürünlerinden mutfak gereçlerine, evinizi güzelleştirecek her şey burada.',
            ],
            [
                'name' => 'Kitap ve Kırtasiye',
                'description' => 'En çok satan kitaplar, defterler ve kırtasiye malzemeleri ile ilham alın.',
            ],
            [
                'name' => 'Spor ve Outdoor',
                'description' => 'Spor ekipmanlarından kamp malzemelerine, aktif yaşam için ihtiyacınız olan her şey.',
            ],
            [
                'name' => 'Sağlık ve Güzellik',
                'description' => 'Cilt bakım ürünleri, makyaj malzemeleri ve sağlıklı yaşam için vitaminler.',
            ],
            [
                'name' => 'Bebek ve Çocuk Ürünleri',
                'description' => 'Güvenilir bebek ürünleri ve çocuklar için eğlenceli oyuncaklar.',
            ],
            [
                'name' => 'Hobi ve Eğlence',
                'description' => 'Müzik aletlerinden model setlere, hobilerinizi keyifle sürdürün.',
            ],
            [
                'name' => 'Otomotiv ve Aksesuar',
                'description' => 'Araç bakım ürünlerinden, araba aksesuarlarına ihtiyacınız olan her şey.',
            ],
            [
                'name' => 'Yiyecek ve İçecek',
                'description' => 'Organik gıdalardan gurme lezzetlere, sofralarınıza tat katacak seçenekler.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 