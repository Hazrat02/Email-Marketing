<?php

use App\Models\Smtp;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getSmtpById')) {
    function getSmtpById($id)
    {
        return Cache::rememberForever("smtp_{$id}", function () use ($id) {
            return Smtp::find($id);
        });
    }
}

if (!function_exists('clearSmtpCache')) {
    function clearSmtpCache($id)
    {
        Cache::forget("smtp_{$id}");
    }
}

if (!function_exists('storeSmtpInCache')) {
    function storeSmtpInCache(Smtp $smtp)
    {
        Cache::forever("smtp_{$smtp->id}", $smtp);
    }
}
