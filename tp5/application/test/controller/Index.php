<?php

namespace app\test\controller;

class Index extends \think\Controller
{
    public function index()
    {
        if (request() -> isGet())
            return $this -> fetch();
        
        dump(request() -> session());
        dump($_POST);

        if ($_POST['__token__'] !== request() -> session()['__token__'])
            echo 'wrong';
        
        return $this -> fetch();
    }
}
