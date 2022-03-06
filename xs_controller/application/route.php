<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    
    '[mysqls]' => [
        '/:model/:name' => ['mysqls/:model/:name',['method'=>'get|post']],
        '/index' => ['mysqls/mysqls/index',['method'=>'get']],
        '/index/updateDb' => ['mysqls/mysqls/updateDb',['method'=>'get']],
    ],
    '[in]' => [
    	'/:model/:name' => ['index/:model/:name',['method'=>'get|post']],
    	'/index/index' => ['index/index/index',['method'=>'get']]
    ]


];
