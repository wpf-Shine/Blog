<?php

namespace app\admin\controller;



class Index extends Base
{
    //重复登录过滤
    public function initialize()
    {
        if (session('?admin.id')) {
            $this->redirect('admin/home/index');
        }
    }

    //后台登录
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            $result = model('Admin')->login($data);
            if ($result == 1) {
                $this->success('登录成功！', 'admin/home/index');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    //注册
    public function register()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            $result = model('Admin')->register($data);
            if ($result == 1) {
                $this->success('注册成功！', 'admin/index/login');
            }else {
                $this->error($result);
            }
        }
        return view();
    }

    //忘记密码
    public function forget()
    {
        return view();
    }
}
