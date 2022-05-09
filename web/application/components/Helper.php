<?php

namespace components;


class Helper
{
    /**
     * @param bool $arr
     */
    public static function pre($arr = false)
    {
        $debug = debug_backtrace();
        echo "<pre  style='background:#fff; color:#000; border:1px solid #CCC;padding:10px;border-left:4px solid red; font:normal 11px Arial;'><small>" . str_replace($_SERVER['DOCUMENT_ROOT'], "", $debug[0]['file']) . " : {$debug[0]['line']}</small>\n" . print_r($arr, true) . "</pre>";
    }

    /**
     * @param $url
     */
    public static function redirect($url)
    {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location:" . $url);
        exit();
    }
}
	