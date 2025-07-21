<!-- 
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
-->
## Requirement
- PHP
- Composer
- Laravel
- MySql

## Features
-  Admin
-  Authentication
-  Login (Admin/User)
-  Reserve Room
-  etc

## Instalation
1. Download or clone this project.
   ```git
   https://github.com/fadenta/peminjaman-lab.git
   ```
2. Navigate to the `app-pinjam-lab` folder.
   ```sh
   cd peminjaman-lab
   ```
3. Install the required components using Composer.
   ```sh
   composer install
   ```
4. Copy the `.env.example` file to `.env`.
   ```sh
   cp .env.example .env
   ```
5. Generate the `APP_KEY`.
   ```sh
   php artisan key:generate
   ```
6. Install Storage.
   ```sh
   php artisan storage:link
   ```
7. Perform the database migration.
   ```sh
   php artisan migrate:fresh --seed
   ```
8. After successful migration, run the application.
   ```sh
   php artisan serve
   ```
9. Open your browser and go to `127.0.0.1:8000` to use the application.
   
