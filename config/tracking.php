<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Log User Details
    |--------------------------------------------------------------------------
    |
    | This option determines whether the user's details (such as user ID) should
    | be logged when a request is processed. Enable or disable it as needed.
    |
    */
    'log_user' => true,

    /*
    |--------------------------------------------------------------------------
    | Log Request Headers
    |--------------------------------------------------------------------------
    |
    | This option specifies whether the headers of incoming requests should be
    | logged. Useful for debugging or analyzing client-specific information.
    |
    */
    'log_headers' => true,

    /*
    |--------------------------------------------------------------------------
    | Log Request Body
    |--------------------------------------------------------------------------
    |
    | Determines whether the body of the incoming requests should be logged.
    | Note: Be cautious when logging sensitive information in request payloads.
    |
    */
    'log_body' => true,

    /*
    |--------------------------------------------------------------------------
    | Log IP Address
    |--------------------------------------------------------------------------
    |
    | Enable or disable logging of the IP address from which the request
    | originated. This can be helpful for tracking user activity.
    |
    */
    'log_ip' => true,

    /*
    |--------------------------------------------------------------------------
    | Log User Agent
    |--------------------------------------------------------------------------
    |
    | This option allows you to log the User-Agent header from incoming
    | requests, providing details about the client's browser or device.
    |
    */
    'log_user_agent' => true,

    /*
    |--------------------------------------------------------------------------
    | Logging Enabled
    |--------------------------------------------------------------------------
    |
    | This option controls whether logging is enabled or disabled globally.
    | Set this to false to completely disable logging.
    |
    */
    'logging_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Route URL
    |--------------------------------------------------------------------------
    |
    | Define the URL endpoint for accessing the request logs. You can
    | customize this to match your application's routing structure.
    |
    */
    'route_url' => 'request-logs',

    /*
    |--------------------------------------------------------------------------
    | Middleware Configuration
    |--------------------------------------------------------------------------
    |
    | Specify the middleware stack to apply to the routes used by this package.
    | The default is 'web', but you can add your own middleware as needed.
    |
    */
    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Check
    |--------------------------------------------------------------------------
    |
    | Define a permission string to control access to the request logs. If
    | specified, users will need this permission to view the logs. Set to null
    | to disable permission checks.
    |
    | Example: 'view-tracking-logs'
    |
    */
    'permission' => null,
];
