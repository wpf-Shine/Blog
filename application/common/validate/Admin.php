<?php

namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|密码' => 'require',
        'oldpass|原密码' => 'require',
        // 'newpass|新密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:admin'
	];

	//登录验证场景
    public function sceneLogin()
    {
        return $this->only(['username', 'password']);
    }

    //注册验证场景
    public function sceneRegister()
    {
    	return $this->only(['username', 'password','conpass','nickname','email'])
			->append('username', 'unique:admin');
    }

    //添加管理员验证场景
    public function sceneAdd()
    {
        return $this->only(['username', 'password','conpass','nickname','email'])
            ->append('username', 'unique:admin');
    }

    //编辑管理员信息场景
    public function sceneEdit()
    {
        return $this->only(['oldpass','newpass','nickname']);
    }
}