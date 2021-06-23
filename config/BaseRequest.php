<?php namespace config;
use config\Request;

class BaseRequest implements Request
{
    private $get = [];
    private $post = [];
    private $all = [];

    public function __construct()
    {
        foreach ($_GET as $key => $value){
            $this->get[$key] = $value;
        }
        foreach ($_POST as $key => $value){
            $this->post[$key] = $value;
        }
        $this->all = array_merge($this->post , $this->get);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if (array_key_exists($name , $this->all)){
            return $this->get[$name];
        }
    }

    public function get()
    {
        return $this->get;
    }

    public function post()
    {
        return $this->post;
    }

    public function all()
    {
        return $this->all;
    }

}