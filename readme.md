# Orders management app

This is a orders app. I built it in Laravel special for Adcash Full stack Developer assignment.

## Features
- CRUD for orders
- Filter orders from today, last 7 days and all time
- Filter ordery by user or product name
- Discount of 20% must be applied to the total cost of any order when at least 3 items of of "Pepsi Cola" are selected

## Additional fatures
- Search by user or product name

## Getting Started

First, clone the repository and cd into it:

```bash
git clone https://github.com/sultansagi/orders-app
cd orders-app
```

Next, update and install with composer:

```bash
composer update --no-scripts
composer install
```

Next, create a .env file off of the .env.example and set the `APP_KEY` variable to the result of the following command:

```bash
cp .env.example .env
php artisan key:generate
```

Next, edit the .env file to hold your MySQL database credentials/host information.

Lastly, run the following command to migrate your database using the credentials:

```bash
php artisan migrate
php artisan db:seed
```

Also we can check PHPUnit tests, by running:
```bash
vendor/bin/phpunit
```

You should now be able to start the server using `php artisan serve` and go to http://localhost:8000 to view the app!

Visit http://localhost:8000. Success!

## Contributing

Feel free to contribute to anything.