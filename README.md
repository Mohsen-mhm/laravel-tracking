# Laravel Request Tracker

## Introduction

The **Laravel Request Tracker** package provides an easy way to log incoming HTTP requests, including metadata like
headers, body, user details, and responses. It supports dynamic configuration for themes, logging preferences, and route
customization.

## Features

- Logs user details, headers, body, and response.
- Tracks IP address and User-Agent.
- Configurable logging options.
- Supports Bootstrap and Tailwind CSS themes for the log viewer.
- Route URL customization.
- Migration publishing for database setup.

## Installation

1. Install the package via Composer:
   ```bash
   composer require mohsen-mhm/laravel-tracking
   ```

2. Publish the configuration file:
   ```bash
   php artisan vendor:publish --tag=tracker-configs
   ```

3. Publish the migrations:
   ```bash
   php artisan vendor:publish --tag=tracker-migrations
   ```

4. Run the migrations:
   ```bash
   php artisan migrate
   ```

5. Publish the views (optional):
   ```bash
   php artisan vendor:publish --tag=tracker-views
   ```

## Configuration

The configuration file (`config/requesttracker.php`) allows you to control the package's behavior:

```php
return [
    'log_user' => true, // Log user details
    'log_headers' => true, // Log headers
    'log_body' => true, // Log body
    'log_response' => true, // Log response content
    'log_ip' => true, // Log IP address
    'log_user_agent' => true, // Log User-Agent
    'theme' => 'bootstrap', // Options: bootstrap, tailwind
    'logging_enabled' => true, // Enable or disable logging
    'route_url' => 'request-logs', // Customizable route URL
];
```

## Usage

### Middleware

The `LogRequests` middleware handles request logging. You can add it to your middleware stack:

```php
protected $middleware = [
    \MohsenMhm\LaravelTracking\Http\Middleware\TrackRequests::class,
];
```

### Accessing the Logs

Visit the route defined in the configuration (`route_url`) to view the logs. For example:

```
http://your-app.test/request-logs
```

## Theming

You can select either `bootstrap` or `tailwind` in the configuration file. The views will adapt accordingly.

## Publishing Migrations

To customize the database schema for logging, publish and modify the migrations:

```bash
php artisan vendor:publish --tag=tracker-migrations
```

## Customizing the Route

You can change the route URL in the configuration file:

```php
'route_url' => 'custom-log-url',
```

Access the logs at:

```
http://your-app.test/custom-log-url
```

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

