<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    public function cate()
    {
        return $this->hasMany('Cate');
    }

    //只读字段 不允许修改
    protected $readonly = ['email'];

    //登录校验
    public function login($data){
    	 $validate = new \app\common\validate\Admin();
         if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
         }
    	 $result = $this->where($data)->find();
    	 if($result){
    	 	//判断用户是否被禁用
    	 	if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
    	 	//1表示有这个用户，也就是用户名和密码正确
    	 	$sessionData = [
    	 		'id' => $result['id'],
    	 		'nickname' => $result['nickname'],
    	 		'is_super' => $result['is_super']
    	 	];
    	 	session('admin',$sessionData);
    	 	return 1;
    	 }
    	 else{
    	 	return '用户名或密码错误！';
    	 }
    }

    //注册账户
    public function register($data){
    	$validate = new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
    	$result = $this->allowField(true)->save($data);
    	if($result){
    		// mailto($data['email'],'注册管理员账户成功！','注册管理员账户成功！');
    		return 1;
    	}else{
    		return '注册失败！';
    	}
    }

    //添加管理员
    public function add($data){
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '管理员添加失败！';
        }
    }

    //管理员信息编辑
    public function edit($data){
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        if($data['oldpass'] != $adminInfo['password']){
            return '原密码不正确！';
        }
        if($data['newpass'] == null){
            $data['newpass'] = $adminInfo['password'];
        }
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $adminInfo->is_super = $data['is_super'];
        $result = $adminInfo->save();
        if($result){
            return 1;
        }else{
            return '管理员信息修改失败！';
        }
    }
}
