<?php

if (!function_exists('isUserOnline')) {
    function isUserOnline($user)
    {
        $timeout = now()->subMinutes(5); // Define your own timeout period
        return $user->last_activity_at && $user->last_activity_at > $timeout;
    }
}
