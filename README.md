# VERONA E-Ticaret Projesi

VERONA, Laravel tabanlı modern bir E-pazaryeri platformudur. Satıcılar ve alıcılar arasında güvenli bir alışveriş deneyimi sunar.

## Kullanılan Teknolojiler

### Backend
- PHP 8.1
- Laravel 10.x
- MySQL Veritabanı
- Laravel Eloquent ORM


### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap 5.3
- Font Awesome 6.5.1


## Özellikler

### Kullanıcı Yönetimi
- Çoklu kullanıcı rolleri (Admin, Satıcı, Alıcı)
- Kullanıcı kaydı ve girişi
- Profil yönetimi
- Adres yönetimi

### Ürün Yönetimi
- Ürün ekleme, düzenleme ve silme
- Çoklu ürün görseli yükleme
- Kategori bazlı ürün organizasyonu
- Stok takibi

### Alışveriş Özellikleri
- Sepet yönetimi
- Favori ürünler
- Kategori bazlı ürün filtreleme
- Detaylı ürün sayfaları

### Admin Paneli
- Kullanıcı yönetimi
- Kategori yönetimi
- Ürün yönetimi
- Satıcı takibi

### Satıcı Paneli
- Ürün yönetimi
- Stok takibi
- Satış istatistikleri

## Kurulum

1. Bağımlılıkları yükleyin:
composer install
npm install

2. .env dosyasını oluşturun:
3. Uygulama anahtarını oluşturun:
php artisan key:generate
4.  Veritabanı ayarlarını yapın:
- .env dosyasında veritabanı bilgilerinizi düzenleyin
- Migrasyonları çalıştırın:
php artisan migrate --seed

5. Uygulamayı çalıştırın:
php artisan serve
npm run dev


## Varsayılan Kullanıcılar

### Admin
- E-posta: admin@verona.com
- Şifre: verona123

## Katkıda Bulunma

1. Bu depoyu fork edin
2. Yeni bir branch oluşturun (`git checkout -b feature/amazing`)
3. Değişikliklerinizi commit edin (`git commit -m 'Yeni özellik eklendi'`)
4. Branch'inizi push edin (`git push origin feature/amazing`)
5. Pull Request oluşturun


## İletişim

Proje ile ilgili sorularınız ve önerileriniz için:
- E-posta: gettrichie@gmail.com
- LinkedIn: [\[LinkedIn profiliniz\]](https://www.linkedin.com/in/ömer-emre-esen-94a244299/)
