## About Coffee Roulette

Coffee Roulette is an application where you can arrange meet ups by signing up and pairing with other users.

## Installation

Use composer to install dependencies

```bash
composer install
```
Then run migrations and seed your database on mysql
```bash
php artisan migrate
```
```bash
php artisan db:seed
```
## Usage 
Run this locally using both
```bash
npm run dev
```
and
```bash
php artisan serve
```

## Configuration

Make sure to add an .env file in the root folder of the project and add these environmental variables

```dosini
APP_NAME="Coffee Roulette"
APP_ENV=local
APP_KEY=base64:dUDZ9dUNCt2k+kLTitYNZ6WoiuZDNZvZfu9VnwPr9FQ=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=CoffeeRoulette
DB_USERNAME=root
DB_PASSWORD=root

MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME="Your email"
MAIL_PASSWORD="Your password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="${MAIL_USERNAME}"
MAIL_FROM_NAME="${APP_NAME}"

MAILGUN_DOMAIN="sandbox1234.mailgun.org"
MAILGUN_SECRET="YOUR API KEY"

```

Use the .env.example file for references