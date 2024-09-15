<?php
namespace Services;
class ENV
{
    public static $base_url;

    public static function getbaseurl()
    {
        if (!isset(self::$base_url)) {
            $first_url = $_SERVER['REQUEST_URI'];
            $first_url = preg_replace('#/+#', '/', $first_url);
            $first_url = rtrim($first_url, '/');
            $parts = explode('/', $first_url, 3);
            self::$base_url = isset($parts[1]) ? '/' . $parts[1] : '/';
        }
        return self::$base_url . '/';
    }
}
