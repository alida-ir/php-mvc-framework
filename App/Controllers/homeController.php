<?php namespace App\Controllers;


use config\Request;
use config\Response;
use App\Models\User;


class homeController
{
    public static function register(Request $request , Response $response)
    {
//        var_dump($request->get());
//        var_dump($response->cookie());
    }
    public static function series($id , Request $request , Response $response)
    {
//        redirect(route('login'));
//        $user = User::find($id);
//        var_dump($request->name());
    }

    public static function allow(Request $request)
    {
//        abort(404);
    }
    public static function show(Request $request)
    {
//        abort(500);
    }
}