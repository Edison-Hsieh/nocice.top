<?php

namespace app\asset\model;

class Comment extends \think\Model
{
    public function getCommentAuthorIdAttr($comment_author_id)
    {
        $user = db('author') -> where('id', $comment_author_id) -> select()[0];

        return \app\my\controller\Name::get_name($user);
    }

    public function getContentAttr($title)
    {
        return htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    }
}
