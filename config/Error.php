<?php namespace config;

class Error
{

    public static function errorHandle($level , $message , $file , $line)
    {
        if (error_reporting() !== 0){
            throw new \ErrorException($message , 0 , $level , $file , $line);
        }
    }

    public static function exceptionHandle($exception)
    {
        $code = $exception->getCode();
        if ($code !== 404){
            $code = 500;
        }

        http_response_code($code);

        if (env('APP_DEBUG') === true){
            $data = [
                "exist" => true ,
                "Class" => get_class($exception),
                "Message" => $exception->getMessage(),
                "GetTraceAsString" => $exception->getTraceAsString(),
                "GetTrace" => $exception->getTrace(),
                "getPrevious" => $exception->getPrevious(),
                "File" => $exception->getFile(),
                "Line" => $exception->getLine(),
                "Code" => $code,
            ];
            return abort($code, $data);

        }else{
            $log = dirname(__DIR__) . '/storage/logs/' . date('Y-m-d') . '.txt';
            ini_set("error_log" , $log);
            $message = "\n\n<p>Uncaught Exception : " .  $exception->getMessage() . "</p>\n";
            $message .= "\n <p> Message : " .  $exception->getMessage()  . "</p>\n";
            $message .= "\n <p> GetTraceAsString : " .  $exception->getTraceAsString()  . "</p>\n";
            $message .= "\n <p> File : " .  $exception->getFile()  . "</p>\n";
            $message .= "\n <p> Line : " .  $exception->getLine()  . "</p>\n";
            $message .= "\n <p> Code : " .  $code  . "</p>\n";
            $message .= "\n----------------******************---------------------**************---------------\n";
            error_log($message);

            return abort($code);
        }

    }

}

?>