<?php
namespace Collageify\Util;

class CollageifyUtil
{
    public static function redirect(String $string)
    {
        header('Location: ' . $string);
        exit();
    }
}
