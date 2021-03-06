<?php  

 namespace app\common\validate;

use think\Validate;


 class Member extends Validate
 {
 	protected $rule = [
        'username|用户名' => 'require|unique:member',
        'password|密码' => 'require',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:member',
        'oldpass|原密码' => 'require',
		// 'newpass|新密码' => 'require',
    ];

 	//添加场景
 	public function sceneAdd()
    {
        return $this->only(['username', 'password', 'nickname', 'email']);
    }

    //编辑场景
    public function sceneEdit()
    {
        return $this->only(['oldpass', 'newpass', 'nickname']);
    }
 }