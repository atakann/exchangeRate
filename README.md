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

#### Register POST request
```
http://localhost:8000/api/register
```
#### Body:
```
{
  "name": "Test User",
  "email": "testuser@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

#### Response:
```
{
    "user": {
        "name": "Test User",
        "email": "testuser@example.com",
        "updated_at": "2023-12-05T16:28:11.000000Z",
        "created_at": "2023-12-05T16:28:11.000000Z",
        "id": 1
    },
    "token": "1|dhjkqKjR0DL6j7hebNUeAKARXlXq9C1ULABQSAw4bc2a18c6"
}
```

#### Login POST request
```
http://localhost:8000/api/register
```
#### Body:
```
{
  "email": "testuser@example.com",
  "password": "password"
}
```

#### Response:
```
{
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "testuser@example.com",
        "email_verified_at": null,
        "created_at": "2023-12-05T16:28:11.000000Z",
        "updated_at": "2023-12-05T16:28:11.000000Z"
    },
    "token": "8|aBd5rb7QxvZhkeOsTXhDTYt6gMT7Eregvaiv5p23cb435f3f"
}
```



### Exchange Rates

| Endpoint            | Method | Description                                      | Auth Required |
|---------------------|--------|--------------------------------------------------|---------------|
| `/exchange-rates`   | GET    | Get the latest five exchange rates from the database.| Yes         |
| `/fetch-rates`      | GET    | Fetch the latest exchange rates from the external API and update the database.| Yes |

#### /exchange-rates endpoint get request with auth bearer token
```
http://localhost:8000/api/exchange-rates
```

#### Auth (Bearer Token we get from login):
```
8|aBd5rb7QxvZhkeOsTXhDTYt6gMT7Eregvaiv5p23cb435f3f
```
#### Response:
```
[
    {
        "id": 4,
        "base_currency": "USD",
        "target_currency": "JPY",
        "rate": "147.194269",
        "created_at": "2023-12-06T00:34:27.000000Z",
        "updated_at": "2023-12-06T01:57:03.000000Z"
    },
    {
        "id": 1,
        "base_currency": "EUR",
        "target_currency": "USD",
        "rate": "1.079261",
        "created_at": "2023-12-06T00:34:26.000000Z",
        "updated_at": "2023-12-06T01:57:02.000000Z"
    },
    {
        "id": 2,
        "base_currency": "EUR",
        "target_currency": "GBP",
        "rate": "0.857106",
        "created_at": "2023-12-06T00:34:26.000000Z",
        "updated_at": "2023-12-06T01:57:02.000000Z"
    },
    {
        "id": 3,
        "base_currency": "GBP",
        "target_currency": "USD",
        "rate": "1.259192",
        "created_at": "2023-12-06T00:34:26.000000Z",
        "updated_at": "2023-12-06T01:57:02.000000Z"
    },
    {
        "id": 5,
        "base_currency": "USD",
        "target_currency": "TRY",
        "rate": "28.859513",
        "created_at": "2023-12-06T00:34:27.000000Z",
        "updated_at": "2023-12-06T01:57:01.000000Z"
    }
]
```



#### /fetch-rates endpoint get request with auth bearer token
```
http://localhost:8000/api/fetch-rates
```

#### Auth (Bearer Token we get from login):
```
8|aBd5rb7QxvZhkeOsTXhDTYt6gMT7Eregvaiv5p23cb435f3f
```
#### Response:
```
[
    {
        "base_currency": "EUR",
        "target_currency": "USD",
        "rate": {
            "code": "USD",
            "value": 1.0792607988
        }
    },
    {
        "base_currency": "EUR",
        "target_currency": "GBP",
        "rate": {
            "code": "GBP",
            "value": 0.8571058627
        }
    },
    {
        "base_currency": "GBP",
        "target_currency": "USD",
        "rate": {
            "code": "USD",
            "value": 1.2591919455
        }
    },
    {
        "base_currency": "USD",
        "target_currency": "JPY",
        "rate": {
            "code": "JPY",
            "value": 147.1942692149
        }
    },
    {
        "base_currency": "USD",
        "target_currency": "TRY",
        "rate": {
            "code": "TRY",
            "value": 28.8595129152
        }
    }
]
```

### Miscellaneous

| Endpoint        | Method | Description                  |
|-----------------|--------|------------------------------|
| `/`             | GET    | Welcome page of the application. |
| `/test-api`     | GET    | Test endpoint for direct API fetch. |

#### test-api test endpoint
```
http://localhost:8000/test-api
```

#### Response:
```
{
    "meta": {
        "last_updated_at": "2023-12-05T23:59:59Z"
    },
    "data": {
        "GBP": {
            "code": "GBP",
            "value": 0.8571058627
        },
        "JPY": {
            "code": "JPY",
            "value": 158.8610045669
        },
        "TRY": {
            "code": "TRY",
            "value": 31.1469409609
        },
        "USD": {
            "code": "USD",
            "value": 1.0792607988
        }
    }
}
```


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

