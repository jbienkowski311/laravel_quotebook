# Laravel Quotebook
Demo application that includes:
* Basic User Authentication (Register, Login)
* API Token Authentication (Bearer)

## Description
This application is showing how to use Restful API with help of Resource Controllers provided by Laravel Framework. There are three models used:

1. User
2. Author
3. Quote

The relationships are as follows:
* Author <=> Quotes - One to Many
* User <=> Quotes - Many to Many

## Installation
1. `git clone git@github.com:jbienkowski311/laravel_quotebook.git` or download and unpack repository
2. Copy `.env.example` to `.env` and set it up:
  * Set up database connection
  * Change `CACHE_DRIVER` to `array`
3. Run `composer update`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan db:seed`
7. Run `php artisan serve`
8. Visit http://localhost:8000
9. Enjoy!

## Seeding Data
Provided seeder by default generates:
* 25 users (includes test user)
* 50 authors
* 400 quotes

Laracasts' TestDummy library is used to generate random data. Its factories are placed in `tests/factories/factories.php` ([more info](https://github.com/laracasts/TestDummy#step-2-create-a-factories-file)). `database/seeds/DatabaseSeeder.php` is a file in which you can change number of created data. 

## Test User
Together with randomly generated data comes the test user. To log in with this user use credentials:  
`E-Mail: test@test.com`  
`Password: password`

All users' passwords are set to `password` by default. To check generated data either look into database or use GET query to `api/v1/users` route (use any user's token as Bearer token for authentication).

## Built on top of:
### Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## Additional libraries:
### Laravel 5 Extended Generators
https://github.com/laracasts/Laravel-5-Generators-Extended

### TestDummy
https://github.com/laracasts/TestDummy
