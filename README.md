<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## PromoCode Generator API

> A sample project to generate promo codes and determine validity

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

or serve with valet

`valet link`

Run Tests

 `php artisan test`

## APIs Postman Collection
https://documenter.getpostman.com/view/3385291/TzY1iGcZ

### Available endpoints
- Create Promotion with related number of promo codes
- Update Promotion - radius, expiry date, event ifo, promo amount etc
- Update Promotion status, updated all promo code statuses too
- Update promo code status
- Check validity of promo code - within radius, status active, expiry date


## Deployment

- The code is deployed to Heroku. 
- CI/CD set up for tests and for deploy to staging with GitHub Actions

### API Base URL
https://promocodes-generator.herokuapp.com

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
