<?php

namespace app\admin\controller;

class Admin extends Base
{
    //管理员列表
    public function lists()
    {
    	$admins = model('Admin')->order(['is_super'=>'asc', 'status'=>'asc'])->paginate(10);
    	$viewData = [
    		'admins' => $admins
    	];
    	$this->assign($viewData);
    	return view();
    }

    //管理员添加
   public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Admin')->add($data);
            if ($result == 1) {
                $this->success('管理员添加成功！', 'admin/admin/lists');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    //管理员状态操作
    public function status()
    {
    	$data = [
    		'id' => input('post.id'),
    		'status' => input('post.status') ? 0 : 1
    	];
    	$adminInfo = model('Admin')->find($data['id']);
    	$adminInfo->status=$data['status'];
    	$result = $adminInfo->save();
    	if($result){
    		$this->success('操作成功！', 'admin/admin/lists');
    	}else{
    		$this.error($result);
    	}
    }

    //管理员编辑
    public function edit()
    {
    	if(request()->isAjax()){
    		$data = [
    			'id' => input('post.id'),
    			'oldpass' => input('post.oldpass'),
    			'newpass' => input('post.newpass'),
    			'is_super' => input('post.is_super', 0),
    			'nickname' => input('post.nickname')
    		];
    		$result = model('Admin')->edit($data);
    		if($result == 1){
    			$this->success('管理员信息修改成功！', 'admin/admin/lists');
    		}else{
    			$this->error($result);
    		}
    	}
    	$adminInfo = model('Admin')->find(input('id'));
    	$viewData = [
    		'adminInfo' => $adminInfo
    	];
    	$this->assign($viewData);
    	return view();
    }

    //删除
    public function del()
    {
    	$adminInfo = model('Admin')->find(input('post.id'));
    	$result = $adminInfo->delete();
    	if($result){
    		$this->success('删除成功！', 'admin/admin/lists');
    	}else{
    		$this->error($result);
    	}
    }
}
