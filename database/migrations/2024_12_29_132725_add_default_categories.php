<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Akıllı telefonlardan dizüstü bilgisayarlara, en son teknoloji ürünlerini burada bulabilirsiniz.'
            ],
            [
                'name' => 'Moda ve Giyim',
                'slug' => 'moda-ve-giyim',
                'description' => 'Kadın, erkek ve çocuklar için en şık kıyafetler ve aksesuarlar.'
            ],
            [
                'name' => 'Ev ve Yaşam',
                'slug' => 'ev-ve-yasam',
                'description' => 'Dekorasyon ürünlerinden mutfak gereçlerine, evinizi güzelleştirecek her şey burada.'
            ],
            [
                'name' => 'Kitap ve Kırtasiye',
                'slug' => 'kitap-ve-kirtasiye',
                'description' => 'En çok satan kitaplar, defterler ve kırtasiye malzemeleri ile ilham alın.'
            ],
            [
                'name' => 'Spor ve Outdoor',
                'slug' => 'spor-ve-outdoor',
                'description' => 'Spor ekipmanlarından kamp malzemelerine, aktif yaşam için ihtiyacınız olan her şey.'
            ],
            [
                'name' => 'Sağlık ve Güzellik',
                'slug' => 'saglik-ve-guzellik',
                'description' => 'Cilt bakım ürünleri, makyaj malzemeleri ve sağlıklı yaşam için vitaminler.'
            ],
            [
                'name' => 'Bebek ve Çocuk Ürünleri',
                'slug' => 'bebek-ve-cocuk-urunleri',
                'description' => 'Güvenilir bebek ürünleri ve çocuklar için eğlenceli oyuncaklar.'
            ],
            [
                'name' => 'Hobi ve Eğlence',
                'slug' => 'hobi-ve-eglence',
                'description' => 'Müzik aletlerinden model setlere, hobilerinizi keyifle sürdürün.'
            ],
            [
                'name' => 'Otomotiv ve Aksesuar',
                'slug' => 'otomotiv-ve-aksesuar',
                'description' => 'Araç bakım ürünlerinden, araba aksesuarlarına ihtiyacınız olan her şey.'
            ],
            [
                'name' => 'Yiyecek ve İçecek',
                'slug' => 'yiyecek-ve-icecek',
                'description' => 'Organik gıdalardan gurme lezzetlere, sofralarınıza tat katacak seçenekler.'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Category::whereIn('slug', [
            'elektronik',
            'moda-ve-giyim',
            'ev-ve-yasam',
            'kitap-ve-kirtasiye',
            'spor-ve-outdoor',
            'saglik-ve-guzellik',
            'bebek-ve-cocuk-urunleri',
            'hobi-ve-eglence',
            'otomotiv-ve-aksesuar',
            'yiyecek-ve-icecek'
        ])->delete();
    }
};
