<?php

namespace app\fragment\controller;

class Index extends \think\Controller
{
    public function header()
    {
        return $this -> fetch();
    }

    public function footer()
    {
        return $this -> fetch();
    }

    public function center()
    {
        return $this -> fetch();
    }

    public function nav()
    {
        return $this -> fetch();
    }

    public function nav_logged_in()
    {
        return $this -> fetch();
    }

    public function add_article_modal()
    {
        return $this -> fetch();
    }

    public function article_script()
    {
        return $this -> fetch();
    }

    public function home_article()
    {
        return $this -> fetch();
    }


}