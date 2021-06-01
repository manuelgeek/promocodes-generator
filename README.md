<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## PromoCode Generator APIs

A sample project to generate promo codes and determine validity

## Set up

`composer install`

`php artisan key:generate`

`cp .env.example .env`

Add database configs to `.env`

`php artisan migarate`

Seed to generate event and codes

`php artisan db:seed`

start server

`php artisan serve`


## APIs Postman Collection
https://documenter.getpostman.com/view/3385291/TzY1iGcZ


## API Base URL
https://promocodes-generator.herokuapp.com

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
