<?php namespace config;

interface Request
{
    public function __construct();

    public function get();
    
    public function __call($name, $arguments);
}