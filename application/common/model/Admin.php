<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    //登录校验
    public function login($data){
    	 $validate = new \app\common\validate\Admin();
         if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
         }
    	 $result = $this->where($data)->find();
    	 if($result){
    	 	//判断用户是否被禁用
    	 	if($result['status'] != 1){
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
}
