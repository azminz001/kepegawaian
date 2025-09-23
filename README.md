<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="120"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>
<p align="center"><img src="https://rsud.brebeskab.go.id/wp-content/uploads/2022/10/logo_rev.svg" height="50"></p>

## Install SIM RSUD Brebes
Ensure that you have <a href="https://getcomposer.org/" target="_blank">Composer</a> and <a href="https://nodejs.org/" target="_blank">Nodejs</a> installed on your machine.

1. Install Composer dependencies:<br />
```bash
composer install
```

2. Install NPM dependencies:<br />
```bash
npm install
```

3. Copy .env.example file and create duplicate. Use cp command for Linux or Mac user. <br />
```bash
cp .env.example .env
```
If you are using Windows, use copy instead of cp.<br />
```bash
copy .env.example .env
```

4. Generate your application encryption key:<br />
```bash
php artisan key:generate
```

6. Start the localhost server:<br />
```bash
php artisan serve
```
Then go to http://127.0.0.1:8000
