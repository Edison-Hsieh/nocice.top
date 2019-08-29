<?php

namespace app\asset\controller;

class Comment extends \think\Controller
{
    public function index()
    {
        \app\login\controller\Check::check_status();

        if (!input('?post.article_comment'))
            echo 'sorry: no comment data received';
        if (!input('?post.article_id'))
            echo 'sorry: no article to comment';
        else
            $comment_content = input('post.article_comment');

        $user_id = $_SESSION['user_id'];
        $article_id = input('post.article_id');
        //尽情地处理逻辑



        $comment = db('comment');

        $comment->insert([
            'article_id' => $article_id, 'content' => $comment_content,
            'comment_author_id' => $user_id, 'time' => date('Y-m-d-H-i-s')
        ]);

        return '<html>
        <meta http-equiv="refresh" content="0;url=/asset/article/article_detail?target=' . $article_id . '"></html>';
    }

    public function respond()
    {
        \app\login\controller\Check::check_status();

        if (empty($_POST['holyshit']) || empty($_POST['target']))
            return 'error';

        $comment_db = db('comment');

        $article_id = db('comment') -> where('id', $_POST['target']) -> select()[0]['article_id'];


        $comment_db -> insert(['content' => $_POST['holyshit'], 'origin_comment_id' => $_POST['target'], 'comment_author_id' => $_SESSION['user_id'], 'article_id' => $article_id, 'time' => date('Y-m-d-H-i-s')]);


        return '<html><meta http-equiv="refresh" content="0;url=/asset/article/article_detail?target=' . $article_id . '"></html>';

    }
}
