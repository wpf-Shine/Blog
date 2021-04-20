<?php

namespace app\admin\controller;


class Member extends Base
{
	//会员列表
    public function lists()
    {
    	$members = model('Member')->order('create_time', 'desc')->paginate(10);
    	$viewData = [
    		'members' => $members
    	];
    	$this->assign($viewData);
    	return view();
    }

    //会员添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Member')->add($data);
            if ($result == 1) {
                $this->success('会员添加成功！', 'admin/member/lists');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    //会员编辑
    public function edit()
    {
    	if(request()->isAjax()){
    		$data = [
    			'id' => input('post.id'),
    			'oldpass' => input('post.oldpass'),
    			'newpass' => input('post.newpass'),
    			'nickname' => input('post.nickname')
    		];
    		$result = model('Member')->edit($data);
    		if($result == 1){
    			$this->success('会员信息修改成功！', 'admin/member/lists');
    		}else{
    			$this->error($result);
    		}
    	}
    	$memberInfo = model('Member')->find(input('id'));
    	$viewData = [
    		'memberInfo' => $memberInfo
    	];
    	$this->assign($viewData);
    	return view();
    }

    //会员删除
    public function del()
    {
        $id = input('post.id');
    	$memberInfo = model('Member')->where('id', $id)->find();
        $commentInfo = model('Comment')->where('member_id', $id)->select();
    	$result = $memberInfo->delete();
        foreach ($commentInfo as $key => $value) {
            if ($memberInfo->id == $value->member_id) {
                $comRes = $value->delete();
                if (!$comRes) {
                    return '删除评论失败！';
                }
            }
        }
    	if($result){
    		$this->success('会员删除成功！', 'admin/member/lists');
    	}else{
    		$this->error($result);
    	}
    	return false;
    }
}
