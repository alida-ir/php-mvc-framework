<?php

if (!function_exists('env_value')){

    function env_value($default)
    {
        return $default() instanceof Closure ? $default() : $default;
    }

}


if (!function_exists('env')){

    function env($env , $default=null)
    {
        $env = $_ENV[$env] ? $_ENV[$env] : $_SERVER[$env];

        if ($env === false){
            return env_value($default);
        }

        switch ($default){
            case "true" :
            case "(true)" :
                return true;

            case "false" :
            case "(false)" :
                return false;

            case "null" :
            case "(null)" :
                return null;

            case "empty" :
            case "(empty)" :
                return "";

        }


    }

}


if (!function_exists('view')){
    function view($View , $Data=[]){
        $viewpatch = dirname(__DIR__) . '/resources/views' ;
        $catchpatch = dirname(__DIR__) . '/storage/views' ;

        $Views = new \Jenssegers\Blade\Blade($viewpatch , $catchpatch);

        echo $Views->make($View , $Data)->render();
    }
}


if (!function_exists('route')){
    function route($name , $parameters = []){
        $uri = \config\Router::$name;
        $http_host = $_SERVER['HTTP_HOST'];
        $call = array_key_exists($name , $uri) ? $uri[$name] : false;
        $protocol = strtolower(explode('/' ,$_SERVER['SERVER_PROTOCOL'])[0]);
        if ($call != false){
            if (preg_match('/\{([a-z0-9-]+)\}/' , $uri[$name])){
                if (!empty($parameters)){
                    foreach ($parameters as $key => $bind){
                        $call = preg_replace('/\{([a-z0-9-]+)\}/' , $bind , $call);
                    }
                }else{
                    throw new ErrorException("Missing required parameter for [Route: {$name}] [URI: {Argument}] [Missing parameter: Argument]." , 404);
                }
            }
            return $protocol . '://' . $http_host . $call;
        }else{
            return false;
        }

    }
}


if (!function_exists('abort')){
    function abort($code , $message = ''){
        $message = ['message' => $message];
        return view("errors.{$code}" , $message);
    }
}


if (!function_exists('redirect')){
    function redirect($addr){
        /* This will give an error. Note the output
         * above, which is before the header() call */
        header('Location: ' . $addr);
        exit();
    }
}

?>