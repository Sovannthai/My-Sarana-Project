<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('is_url_reachable')) {
    /**
     * Check if the given URL is reachable.
     *
     * @param  string  $url
     * @return bool
     */
    function is_url_reachable($url)
    {
        if (empty($url)) {
            return false;
        }

        try {
            $response = Http::timeout(2)->get($url);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
