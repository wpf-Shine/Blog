<?php

namespace app\admin\controller;

use think\Controller;

class Comment extends Controller
{
    //评论列表
    public function lists()
    {
    	$where = [];
    	$comments = model('Comment')->where($where)->with('article,member')->order('create_time', 'desc')->paginate(10);
    	$viewData = [
    		'comments' => $comments
    	];
    	$this->assign($viewData);
    	return view();
    }

    //评论删除
    public function del()
    {
    	$commentInfo = model('Comment')->find(input('post.id'));
    	$result = $commentInfo->delete();
    	if($result){
    		$this->success('评论删除成功！', 'admin/comment/lists');
    	}else{
    		$this->error('评论删除失败！');
    	}
    }
}
