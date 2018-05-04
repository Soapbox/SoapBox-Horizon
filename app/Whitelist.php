<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class Whitelist
{
    /**
     * Check to see if the given email is whitelisted
     *
     * @param string $email
     *
     * @return bool
     */
    public static function contains(string $email): bool
    {
        return self::all()->contains($email);
    }

    /**
     * Add the given email to the whitelist
     *
     * @param string $email
     *
     * @return void
     */
    public static function add(string $email): void
    {
        Redis::sadd('user:whitelist', $email);
    }

    /**
     * Remove the given email from the whitelist
     *
     * @param string $email
     *
     * @return void
     */
    public static function remove(string $email): void
    {
        Redis::srem('user:whitelist', $email);
    }

    /**
     * Get all the emails on the whitelist
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all(): Collection
    {
        return collect(Redis::smembers('user:whitelist'));
    }
}
