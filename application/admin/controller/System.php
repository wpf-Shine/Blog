<?php

namespace app\admin\controller;

use think\Controller;

class System extends Controller
{
    //系统设置
    public function set()
    {
    	$webInfo = model('System')->find();
    	$viewData = [
    		'webInfo' => $webInfo
    	];
    	$this->assign($viewData);
    	return view();
    }
}
