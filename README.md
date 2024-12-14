# Laravel Request Tracker

## Introduction

The **Laravel Request Tracker** package provides an easy way to log incoming HTTP requests, including metadata like
headers, body, user details, and responses. It supports dynamic configuration for themes, logging preferences, and route
customization.

## Features

- Logs user details, headers, body, and response.
- Tracks IP address and User-Agent.
- Configurable logging options.
- Supports Bootstrap and Tailwind CSS themes for the log viewer. (soon)
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

The configuration file (`config/tracking.php`) allows you to control the package's behavior:

## Usage

### Middleware

The `TrackRequests` middleware handles request logging. You can add it to your middleware stack:

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

