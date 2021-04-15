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
                'id' => input('id'),
                'catename' => input('catename'),
            ];
            $result = model('Cate')->edit($data);
            if($result == 1){
                $this->success('栏目编辑成功！', 'admin/cate/list');
            }else{
                $this->error($result);
            }
        }

        $cateInfo = model('Cate')->find(input('id'));    //bug待修改  修改数据id不对应
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
        $cateInfo = model('Cate')->find(input('post.id'));
        $result = $cateInfo->delete();
        if($result){
            $this->success('栏目删除成功！', 'admin/cate/list');
        }else{
            $this->error('栏目删除失败！');
        }
    }
}