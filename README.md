# Pizza Test Task
Simple web application for ordering pizza.

### Features
* Authentication
* Guest access
* Saving delivery data for users
* Product cart
* Order history
* Two currencies

## Requirements
* PHP 7.2   
* node js, npm
* mysql \ pgsql

## Installation steps
* Clone repository
* Create database
* Create .env from .env.example and update variables
* Run following commands:
    * composer install
    * npm install
    * npm run dev
    * php artisan key:generate
    * php artisan migrate
    * php artisan db:seed
