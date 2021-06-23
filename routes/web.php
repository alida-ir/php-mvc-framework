<?php
use config\Router;



Router::Post('allow' , [\App\Controllers\homeController::class , 'allow']);
Router::Get('/register' ,[\App\Controllers\homeController::class , 'register'])->name('register');
Router::Get('/series/{id}/view' ,[\App\Controllers\homeController::class , 'series'])->name('series');



Router::Get('/' , function (){
    return view('welcome');
});


Router::Get('/login' ,function (){
    return view('login');
})->name('login');



?>