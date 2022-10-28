<?php

namespace App\Shared\Models;

class MyHelper
{
    public static function idExtractor($array, $fieldname = 'id')
    {
        $ids = [];
        foreach ($array as $item) {
            array_push($ids, $item[$fieldname]);
        }

        return $ids;
    }
}
