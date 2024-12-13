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
            return $user->email ?? $user->phone ?? $user->username ?? $user->code ?? $user->id ?? null;
        }
        // Handle arrays
        if (is_array($user)) {
            return $user['email'] ?? $user['phone'] ?? $user['username'] ?? $user['code'] ?? $user['id'] ?? null;
        }
        // Default fallback
        return null;
    }
}
