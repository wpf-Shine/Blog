<?php

namespace app\admin\controller;

class Cate extends Base
{
    //栏目列表
    public function list(){
        $cates = model('Cate')->order('sort', 'asc')->paginate(10);
        //定义一个模板数据变量
        $viewData = [
            'cates'=>$cates
        ];
        $this->assign($viewData);
    	return view();
    }

    //栏目添加
    public function add(){
    	if(request()->isAjax()){
    		$data = [
    			'catename' => input('post.catename'),
    			'sort' => input('post.sort')
    		];
    		$result = model('Cate')->add($data);
    		if($result == 1){
    			$this->success('栏目添加成功！','admin/cate/list');
    		}else{
    			$this->error($result);
    		}
    	}
    	return view();
    }

    //栏目排序
    public function sort(){
        $data = [
            'id'=>input('post.id'),
            'sort'=>input('post.sort')
        ];
        $result = model('Cate')->sort($data);
        if($result == 1){
            $this->success('排序更新成功！', 'admin/cate/list');
        }else{
            $this->error($result);
        }
    }

    //栏目编辑
    public function edit()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename'),
            ];
            $result = model('Cate')->edit($data);
            if($result == 1){
                $this->success('栏目编辑成功！', 'admin/cate/list');
            }else{
                $this->error($result);
            }
        }

        $cateInfo = model('Cate')->find([input('id')]);    
        //模板变量
        $viewData = [
            'cateInfo' => $cateInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //栏目删除
    public function del()
    {
        // $cateInfo = model('Cate')->with('article')->find(input('post.id'));
        // $result = $cateInfo->together('article')->delete();
        $id = input('post.id');
        $articleInfo = model('Article')->where('cate_id',$id)->select();
        $cateInfo = model('Cate')->where('id',$id)->find();
        $result = $cateInfo->delete();
        foreach ($articleInfo as $key => $value) {
            if ($cateInfo->id == $value->cate_id) {
                // 栏目与文章拥有共同数据,执行删除文章
                $artRes = $value->delete();
                if (!$artRes) {
                    return '删除文章失败';
                }

                //评论数据
                $comInfo = model('Comment')->where('article_id',$value->id)->select();
                // 遍历评论数据,如果评论在删除文章中,一起删除
                foreach ($comInfo as $key => $c) {
                    // $c 是评论数据
                    if ($c->article_id == $value->id) {
                        // 执行删除评论
                        $comRes = $c->delete();
                        if (!$comRes) {
                            return '删除评论失败';
                        }
                    }
                }
            }
        }
        if ($result) {
            $this->success('栏目删除成功！', 'admin/cate/list');
        }else {
            $this->error('栏目删除失败！');
        }
    }
}
