# Exchange Rate Service

## Overview
This Laravel-based project provides an API for registering users, logging in, and fetching exchange rates from an external API. It includes user authentication, exchange rate data fetching, and data persistence in a MySQL database.

## Setup Instructions

### Prerequisites
- PHP 8.x
- Laravel 9.x
- MySQL

### Database Setup
1. Create a MySQL database for the application.
2. Update `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

### Running the Application
1. Install dependencies:
   ```
   composer install
   ```
2. Run database migrations:
   ```
   php artisan migrate
   ```
3. Start the Laravel server:
   ```
   php artisan serve
   ```

## API Endpoints

### User Authentication

| Endpoint        | Method | Description           | Auth Required |
|-----------------|--------|-----------------------|---------------|
| `/register`     | POST   | Register a new user.  | No            |
| `/login`        | POST   | Login an existing user.| No           |

### Exchange Rates

| Endpoint            | Method | Description                                      | Auth Required |
|---------------------|--------|--------------------------------------------------|---------------|
| `/exchange-rates`   | GET    | Get the latest five exchange rates from the database.| Yes         |
| `/fetch-rates`      | GET    | Fetch the latest exchange rates from the external API and update the database.| Yes |

### Miscellaneous

| Endpoint        | Method | Description                  |
|-----------------|--------|------------------------------|
| `/`             | GET    | Welcome page of the application. |
| `/test-api`     | GET    | Test endpoint for direct API fetch. |

## Scheduled Tasks
The application is configured to fetch and update exchange rates every 15 minutes using Laravel's scheduler.

In `app\Console\Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $service = new ExchangeRateService();
        $service->fetchAndUpdateRates();
    })->everyFifteenMinutes();
}
```


## Logging
The application logs user requests to the `/exchange-rates` endpoint for auditing purposes.

