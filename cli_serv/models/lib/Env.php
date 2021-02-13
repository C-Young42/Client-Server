<?php
// used to always set the correct file path
class Env
{
    public static function dir()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }
}