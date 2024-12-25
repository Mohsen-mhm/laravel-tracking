<?php
if (!function_exists('getUserTitle')) {
    /**
     * Get the user field in the specified order.
     *
     * @param mixed $user
     * @return string|null
     */
    function getUserTitle(mixed $user): ?string
    {
        // Handle null or scalar values early
        if (is_null($user) || is_scalar($user)) {
            return null;
        }
        // Handle JsonSerializable objects
        if ($user instanceof JsonSerializable) {
            $user = $user->jsonSerialize();
        }
        // Handle objects
        if (is_object($user)) {
            if ($user->email) {
                return $user->email;
            } elseif ($user->phone) {
                return $user->phone;
            } elseif ($user->username) {
                return $user->username;
            } elseif ($user->code) {
                return $user->code;
            } elseif ($user->id) {
                return $user->id;
            }
        }
        // Handle arrays
        if (is_array($user)) {
            if (array_key_exists('email', $user) && $user['email']) {
                return $user['email'];
            } elseif (array_key_exists('phone', $user) && $user['phone']) {
                return $user['phone'];
            } elseif (array_key_exists('username', $user) && $user['username']) {
                return $user['username'];
            } elseif (array_key_exists('code', $user) && $user['code']) {
                return $user['code'];
            } elseif (array_key_exists('id', $user) && $user['id']) {
                return $user['id'];
            }
        }
        // Default fallback
        return null;
    }
}

if (!function_exists('request_logs_asset')) {
    /**
     * Generate an asset path for the package.
     *
     * @param string $path
     * @return string
     */
    function request_logs_asset($path)
    {
        // Check if the asset has been published
        if (file_exists(public_path('vendor/request-tracker/' . $path))) {
            return asset('vendor/request-tracker/' . $path);
        }

        // Fallback to package assets
        return "https://cdn.tailwindcss.com";
    }
}