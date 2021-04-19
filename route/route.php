<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::group('admin', function () {
    Route::rule('/', 'admin/index/login');
    Route::rule('register', 'admin/index/register');
    Route::rule('forget', 'admin/index/forget');
    Route::rule('index', 'admin/home/index');
    Route::rule('loginout', 'admin/home/loginout');
    //栏目管理路由
    Route::rule('catelist','admin/cate/list');
    Route::rule('cateadd', 'admin/cate/add');
    Route::rule('catesort', 'admin/cate/sort');
    Route::rule('cateedit/[:id]', 'admin/cate/edit'); 
    Route::rule('catedel', 'admin/cate/del');
    //文章管理路由
    Route::rule('articlelist', 'admin/article/list');
    Route::rule('articleadd', 'admin/article/add');
    Route::rule('articletop', 'admin/article/top');
    Route::rule('articleedit/[:id]', 'admin/article/edit');
    Route::rule('articledel', 'admin/article/del');
    //会员管理路由
    Route::rule('memberlist', 'admin/member/lists');
    Route::rule('memberadd', 'admin/member/add');
    Route::rule('memberedit/[:id]', 'admin/member/edit');
    Route::rule('memberdel', 'admin/member/del');
    //管理员管理路由
    Route::rule('adminlist', 'admin/admin/lists');
    Route::rule('adminadd', 'admin/admin/add');
    Route::rule('adminstatus', 'admin/admin/status');
    Route::rule('adminedit/[:id]', 'admin/admin/edit');
    Route::rule('admindel', 'admin/admin/del');
});

