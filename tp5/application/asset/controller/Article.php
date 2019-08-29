<?php

namespace app\asset\controller;


class Article extends \think\Controller
{

    public function index()
    {
        $db = db('comment');

        $article_id = input('get.target');

        if (!$article_id)
            return 'hhhh';

        $comments = \app\asset\model\Comment::where('article_id', $article_id) -> order('time desc') ->paginate(5);

        $this -> assign('comments', $comments);

        $this -> assign('comment_db', db('comment'));

        return $this -> fetch();
        
    }

    public function incr_score()
    {
        if (request()->isPost() && input('?post.target') && input('?post.operating')) {

            $id = input('post.target');

            $db = db('article');
            $result = $db->where('id', $id)->select();

            if (input('post.operating')) {
                $origin_score = $result[0]['down'];
                $db->where('id', $id)->update(['down' => $origin_score + 1]);
            } else {
                $origin_score = $result[0]['up'];
                $db->where('id', $id)->update(['up' => $origin_score + 1]);
            }
        }
    }

    public function decr_score()
    {
        if (request()->isPost() && input('?post.target') && input('?post.operating')) {

            $id = input('post.target');

            $db = db('article');
            $result = $db->where('id', $id)->select();

            if (input('post.operating')) {
                $origin_score = $result[0]['down'];
                $db->where('id', $id)->update(['down' => $origin_score - 1]);
            } else {
                $origin_score = $result[0]['up'];
                $db->where('id', $id)->update(['up' => $origin_score - 1]);
            }
        }
    }

    public function article_detail()
    {
        session_start();

        if (input('?get.target'))
            $article_id = input('get.target');
        else
            exit('target not find');

        if (isset($_SESSION['user_id'])) {
            $top_left = '<li><a style="cursor: pointer;" data-toggle="modal" data-target="#add_article"><i class="fas fa-user-edit"></i> Add Article </a></li>';
            $top_right = '<li><a href="/my" style="font-size: 18px"><i class="fas fa-user"></i> My Account</a></li>';
        } else {
            $top_left = '';
            $top_right = '<li><a href="/login">Log In</a></li>
                              <li><a href="/register">Sign Up</a></li>';
        }

        
        $this->assign('top_left', $top_left);
        $this->assign('top_right', $top_right);

        try {
            $db = db('article');
            
            $article = \app\my\model\Article::where('id', $article_id)->select();
            if (!count($article))
                exit('Sorry, article not find. Maybe it was deleted by the author just now.');

            $next = \app\my\model\Article::where('id', '<', $article_id) ->order('id desc') ->select();
            $last = \app\my\model\Article::where('id', '>', $article_id)->select();


            if (count($next))
            {
                $next_id = $next[0]['id'];
                $next_one = '<li class="next"><a href="/asset/article/article_detail?target=' . $next_id . '">Next <span aria-hidden="true">&rarr;</span></a></li>';
            }
            else
                $next_one = '<li class="next disabled"><a>Next <span aria-hidden="true">&rarr;</span></a></li>';
  
            
            if (count($last))
            {
                $last_id = $last[0]['id'];
                $last_one = '<li class="previous"><a href="/asset/article/article_detail?target=' . $last_id . '"><span aria-hidden="true">&larr;</span> Last</a></li>';
            }
            else
                $last_one  = '<li class="previous disabled"><a><span aria-hidden="true">&larr;</span> Last</a></li>';
 

            $this -> assign(['last_one' => $last_one, 'next_one' => $next_one]);


            $this->assign('article', $article[0]);

            $db = db('category');
            $categories = $db->select();
            $this->assign('categories', $categories);



            //开始处理评论模块
            $db = db('comment');

            $comments = \app\asset\model\Comment::where('article_id', $article_id) -> order('time desc') ->paginate(5);


            $this -> assign('comments', $comments);



            $this -> assign('article_id', $article_id);









        } catch (\think\exception\PDOException $e) {
            echo '<h1>Sorry, database error occurred😐</h1>';
            echo '<h1>We hope you report this error to our website administrator🙃</h1>';
        }

        return $this->fetch();
    }



}
