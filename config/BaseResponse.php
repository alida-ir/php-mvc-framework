<?php namespace config;
use config\Response;
class BaseResponse implements Response
{
    public static function cookie()
    {
        return $_COOKIE;
    }
}