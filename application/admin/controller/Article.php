<?php

namespace app\admin\controller;

class Article extends Base
{
    //文章列表
    public function list()
    {
    	$articles = model('Article')->with('cate')->order(['is_top'=>'aesc','create_time' => 'desc'])->paginate(10);
    	$viewData = [
    		'articles' => $articles
    	];
    	$this->assign($viewData);
    	return view();
    }

    //文章添加
    public function add()
    {
    	if(request()->isAjax()){
    		$data = [
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->add($data);
            if($result==1){
            	$this->success('文章添加成功','admin/article/list');
            }else{
            	$this->error($result);
            }
    	}
    	$cates = model('Cate')->select();
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //置顶操作
    public function top()
    {
        $data = [
            'id' => input('post.id'),
            'is_top' => input('post.is_top') ? 0 : 1
        ];
        $result = model('Article')->top($data);
        if ($result == 1) {
            $this->success('操作成功！', 'admin/article/list');
        }else {
            $this->error($result);
        }
    }

    //文章编辑
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->edit($data);
            if ($result == 1) {
                $this->success('文章编辑成功！', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }
        $articleInfo = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        $viewData = [
            'articleInfo' => $articleInfo,
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //文章删除
    public function del()
    {
        $id = input('post.id');
        $articleInfo = model('Article')->where('id', $id)->find();
        $commentInfo = model('Comment')->where('article_id', $id)->select();
        $result = $articleInfo->delete();
        foreach ($commentInfo as $key => $value) {
            if ($articleInfo->id == $value->article_id) {
                $comRes = $value->delete();
                if (!$comRes) {
                    return '删除评论失败！';
                }
            }
        }
        if($result){
            $this->success('文章删除成功！', 'admin/article/list');
        }else{
            $this->error('文章删除失败！');
        }
    }
}
