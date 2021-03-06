<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
    //软删除
    use SoftDelete;

    //关联文章
    public function article()
    {
        return $this->belongsTo('Article', 'article_id', 'id');
    }

    //关联用户
    public function member()
    {
        return $this->belongsTo('Member', 'member_id', 'id');
    }
}
