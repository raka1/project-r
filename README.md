# Project R

## Cara Install
Clone repository terlebih dahulu:
```
git clone https://github.com/raka1/project-r.git
```
Masuk ke direktori dan install dependencies:
```
cd project-r
npm install && npm run build
composer install
```
Setup database dan jalankan aplikasi:
```
cp .env.example .env
php artisan key:generate
php artisan migrate
composer run dev
```
