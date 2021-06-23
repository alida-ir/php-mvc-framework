<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => env('DB_DRIVE','mysql'),
    'host'      => env('DB_HOSTS','localhost'),
    'database'  => env('DB_DATABASE','database'),
    'username'  => env('DB_USERNAME','root'),
    'password'  => env('DB_PASSWORD','password'),
    'charset'   => env('DB_CHARSET','utf8'),
    'collation' => env('DB_COLLATION','utf8_unicode_ci'),
    'prefix'    => env('DB_PREFIX',''),
]);

$capsule->bootEloquent();
?>