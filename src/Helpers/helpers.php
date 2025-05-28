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
        if (is_null($user) || is_scalar($user)) {
            return null;
        }

        if ($user instanceof JsonSerializable) {
            $user = $user->jsonSerialize();
        }

        if (is_object($user)) {
            return $user->email ?? $user->phone ?? $user->username ?? $user->code ?? $user->id ?? null;
        }

        if (is_array($user)) {
            return $user['email'] ?? $user['phone'] ?? $user['username'] ?? $user['code'] ?? $user['id'] ?? null;
        }

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