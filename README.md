# Message Log

## Prerequisites
- PHP
- MySQL
- Composer
- Angular 11

## Installation
- clone repo
- cd server
- composer install
- mysql -u root -p
- mysql> create database message_log; 
- modify .env file (mySQL connection params)
- php artisan key:generate
- php artisan migrate:fresh --seed
- php artisan serve
- cd client 
- npm install
- npm run start