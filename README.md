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

---

## Compatibility

### Laravel Version Support

> **This package supports Laravel 9, 10, and 11.**

We ensure compatibility with the latest Laravel versions while maintaining support for older versions starting from Laravel 9. 

To install the package in your Laravel project, make sure you have `PHP 8.0` or above and run:

```bash
composer require mohsen-mhm/laravel-tracking
```

For Laravel 9, the package ensures compatibility by leveraging `doctrine/dbal` version `^3.x`. For Laravel 10 and 11, the package uses `doctrine/dbal` version `^4.x`. These are dynamically managed based on your Laravel version.

---

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
## Custom IP Resolution

You can define your own IP resolution logic by setting a callback in your `config/tracking.php`:

```php
'ip_resolver' => function (Request $request) {
    return $request->header('X-Forwarded-For') ?? $request->ip();
},
```

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

