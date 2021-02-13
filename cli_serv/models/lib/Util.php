<?php


class Util
{
    public static function cleanRequestParams($paramArray)
    {
        foreach ($paramArray as $key => $value) {
            $paramArray[$key] = htmlentities($value);
        }
        return $paramArray;
    }
}