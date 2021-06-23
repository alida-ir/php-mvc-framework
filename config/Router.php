<?php namespace config;
class Router
{
    private static $get_routes = [];
    private static $post_routes = [];
    private static $parameters = [];
    private static $uri = null;
    public static $name = [];

    /**
     * @param $Url
     * @param array|callable $Action
     * @return Router
     */
    public static function Get($Url , $Action)
    {
            static::$uri = $Url;
            $url = preg_replace('/^\//', '', $Url);
            $url = preg_replace('/\/$/', '', $url);
            $url = preg_replace('/\//', '\\/', $url);
            $url = preg_replace('/\{([a-z0-9-]+)\}/', '(?<\1>[a-z0-9-]+)', $url);
            //        $url = preg_replace('/\:([a-z0-9]+)/' , '(?<\1>[a-z0-9-]+)' , $url);
            $url = '/^' . $url . '$/i';
            if (is_object($Action)) {
                $allparams = $Action;
            } elseif (is_string($Action[0])) {
                $allparams['controller'] = $Action[0];
                $allparams['method'] = $Action[1];
                $allparams['uri'] = $url;
                $allparams['method_send'] = 'GET';
            } elseif (is_array($Action[0])) {
                $allparams['controller'] = $Action[0][0];
                $allparams['method'] = $Action[0][1];
                $allparams['uri'] = $url;
                unset($Action[0]);
                $allparams = array_merge($allparams, $Action);
                $allparams['method_send'] = 'GET';
            }
            static::$get_routes[$url] = $allparams;
            return new self;
    }

    public static function Post($Url , $Action)
    {
            static::$uri = $Url;
            $url = preg_replace('/^\//', '', $Url);
            $url = preg_replace('/\/$/', '', $url);
            $url = preg_replace('/\//', '\\/', $url);
            $url = preg_replace('/\{([a-z0-9-]+)\}/', '(?<\1>[a-z0-9-]+)', $url);
            //        $url = preg_replace('/\:([a-z0-9]+)/' , '(?<\1>[a-z0-9-]+)' , $url);
            $url = '/^' . $url . '$/i';
            if (is_object($Action)) {
                $allparams = $Action;
            } elseif (is_string($Action[0])) {
                $allparams['controller'] = $Action[0];
                $allparams['method'] = $Action[1];
                $allparams['uri'] = $url;
            } elseif (is_array($Action[0])) {
                $allparams['controller'] = $Action[0][0];
                $allparams['method'] = $Action[0][1];
                $allparams['uri'] = $url;
                unset($Action[0]);
                $allparams = array_merge($allparams, $Action);
            }

            $allparams['method_send'] = 'POST';
            static::$post_routes[$url] = $allparams;
            return new self;

    }

    private static function Match_GET($url)
    {
        $url = preg_replace('/^\//' , '' , $url);
        $url = preg_replace('/\/$/' , '' , $url);
        foreach (static::$get_routes as $route => $params){
            if (preg_match($route , $url , $matches)){
                foreach ($matches as $key => $value){
                    if (is_string($key)){
                        $params['params'][$key] = $value;
                    }
                }
                static::$parameters = $params;
                return  true;


            }


        }
        return false;

    }

    private static function Match_POST($url)
    {
        $url = preg_replace('/^\//' , '' , $url);
        $url = preg_replace('/\/$/' , '' , $url);
        foreach (static::$post_routes as $route => $params){
            if (preg_match($route , $url , $matches)){
                foreach ($matches as $key => $value){
                    if (is_string($key)){
                        $params['params'][$key] = $value;
                    }
                }
                static::$parameters = $params;
                return  true;


            }


        }
        return false;

    }

    public static function Dispatch($url)
    {
        $url = static::RemoveQueryStringForUrl($url);

        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            if (static::Match_GET($url)){
                if (!is_object(static::$parameters)) {
                    $explode = explode('\\', static::$parameters['controller']);
                    $class = end($explode);
                    if (class_exists(static::$parameters['controller'])) {
                        $method = static::$parameters['method'];
                        if (method_exists(static::$parameters['controller'], static::$parameters['method'])) {
                            $request = new \config\BaseRequest();
                            $response = new \config\BaseResponse();
                            if (array_key_exists('params', static::$parameters)) {
                                call_user_func_array([static::$parameters['controller'], static::$parameters['method']], [static::$parameters['params'] , $request , $response]);
                            } else {
                                call_user_func([static::$parameters['controller'], static::$parameters['method']], $request , $response);
                            }
                        } else {
                            throw new \ErrorException("Your Method {$method} Not Exist !", 404);
                        }
                    } else {
                        throw new \ErrorException("Your Class {$class} Not Exist !", 404);
                    }
                }else{
                    $callable = static::$parameters;
                    $callable();
                }
            }
            else{
                throw new \ErrorException('Your Url Is Not Found !' , 404);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST"){
            if (static::Match_POST($url)){
                if (!is_object(static::$parameters)) {
                    $explode = explode('\\', static::$parameters['controller']);
                    $class = end($explode);
                    if (class_exists(static::$parameters['controller'])) {
                        $method = static::$parameters['method'];
                        if (method_exists(static::$parameters['controller'], static::$parameters['method'])) {
                            if (array_key_exists('params', static::$parameters)) {
                                call_user_func_array([static::$parameters['controller'], static::$parameters['method']], [static::$parameters['params']]);
                            } else {
                                call_user_func([static::$parameters['controller'], static::$parameters['method']], []);
                            }
                        } else {
                            throw new \ErrorException("Your Method {$method} Not Exist !", 404);
                        }
                    } else {
                        throw new \ErrorException("Your Class {$class} Not Exist !", 404);
                    }
                }else{
                    $callable = static::$parameters;
                    $callable();
                }
            }
            else{
                throw new \ErrorException('Your Url Is Not Found !' , 404);
            }
        }
    }

    private static function RemoveQueryStringForUrl($url)
    {
        $url = explode('?' , $url);
        if (strpos('=' , $url[0]) === false){
            return $url[0];
        }else{
            throw new \ErrorException("Your Url Not Exist !" , 404);
        }
    }

    public function name(string $name)
    {
        static::$name[$name] = static::$uri;return $this;
    }

}


?>