# laravel-crawler-trial

### Requirement
 - php > 7.4 (higher than php 8 not tested)
 - node > 14
 - composer

### Setup
Copy `.env.example` to `.env` and then config DB connection
```
cp .env.example .env
```

Install dependencies
```
composer install
```
Install puppeteer for screenshot feature
```
npm install puppeteer --location=global
```

Generate key
```
php artisan key:generate
```

Run migration
```
php artisan migrate
```
start server in serve
```
php artisan serve
```

### Change API EndPoint
Change MIX_URL in `.env` file.
```
MIX_URL=NEW_API_ENDPOINT
```
Then rebuild js files.
```
npm run prod
```
