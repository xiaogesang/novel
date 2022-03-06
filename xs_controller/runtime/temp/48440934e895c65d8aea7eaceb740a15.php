<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\WWW\xs_controller\public/../application/admin\view\novel\lists.html";i:1621050348;s:55:"D:\WWW\xs_controller\application\admin\view\layout.html";i:1617248326;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>
小说列表
</title>
    <link rel="stylesheet" href="/admin/css/pintuer.css">
    <link rel="stylesheet" href="/admin/css/admin.css">
    
    <script src="/admin/js/jquery.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <link rel="stylesheet" href="/admin/js/kindeditor/plugins/code/prettify.css" />
    <script charset="utf-8" src="/admin/js/kindeditor/kindeditor.js"></script>
    <script charset="utf-8" src="/admin/js/kindeditor/lang/zh_CN.js"></script>
    <script charset="utf-8" src="/admin/js/kindeditor/plugins/code/prettify.js"></script>
    <script>
        KindEditor.ready(function(K) {
            var editor1 = K.create('textarea[name="content"],textarea[name="introduction"],textarea[name="team"],textarea[name="dream"]', {
                cssPath : '/admin/js/kindeditor/plugins/code/prettify.css',
                uploadJson : '/admin/js/kindeditor/php/upload_json.php',
                fileManagerJson : '/admin/js/kindeditor/php/file_manager_json.php',
                allowFileManager : true,
                afterCreate : function(){
                    var self = this;
                    K.ctrl(document, 13, function() {
                        self.sync();
                        K('form[name=example]')[0].submit();
                    });
                    K.ctrl(self.edit.doc, 13, function() {
                        self.sync();
                        K('form[name=example]')[0].submit();
                    });
                }
            });
            prettyPrint();
        });
    </script>
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
    <div class="logo margin-big-left fadein-top">
        <h1><img src="/admin/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
    </div>
    <div class="head-l"><a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;<a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href=""><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
    <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
    <h2 <?php if($controller=="Admin"||$controller=="Banner"||$controller=="User"||$controller=="Apoint"||$controller=="Index"): ?> class="on" <?php endif; ?>><span class="icon-user"></span>基本设置</h2>
    <ul <?php if($controller=="Admin"||$controller=="Banner"||$controller=="User"||$controller=="Apoint"||$controller=="Index"): ?> style="display: block;" <?php endif; ?>>
        <li><a href="<?php echo url('admin/admin/lists'); ?>" <?php if($controller=="Admin"): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>管理员设置</a></li>
    </ul>
    <h2 <?php if($controller=="Novel"||$controller=="Comment"): ?> class="on" <?php endif; ?>><span class="icon-user"></span>小说设置</h2>
    <ul <?php if($controller=="Novel"||$controller=="Comment"): ?> style="display: block;" <?php endif; ?>>
        <li><a href="<?php echo url('admin/novel/types'); ?>" <?php if($controller=="Novel"&&($action=='types'||$action=='addtype'||$action=='updatetype')): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>小说分类设置</a></li>
        <li><a href="<?php echo url('admin/novel/lists'); ?>" <?php if($controller=="Novel"&&($action!='types'&&$action!='addtype'&&$action!='updatetype')): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>小说列表</a></li>
        <li><a href="<?php echo url('admin/comment/lists'); ?>" <?php if($controller=="Comment"): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>小说评论</a></li>

    </ul>
    <h2 <?php if($controller=="Banner"): ?> class="on" <?php endif; ?>><span class="icon-pencil-square-o"></span>广告管理</h2>
    <ul <?php if($controller=="Banner"): ?> style="display: block;" <?php endif; ?>>
        <li><a href="<?php echo url('admin/banner/lists'); ?>"  <?php if($controller=="Banner"): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>轮播管理</a></li>
    </ul>
    <h2 <?php if($controller=="User"): ?> class="on" <?php endif; ?>><span class="icon-pencil-square-o"></span>用户管理</h2>
    <ul <?php if($controller=="User"): ?> style="display: block;" <?php endif; ?>>
        <li><a href="<?php echo url('admin/User/lists'); ?>" <?php if($controller=="User"): ?> class="on" <?php endif; ?>><span class="icon-caret-right"></span>用户列表</a></li>
    </ul>
</div>
<script type="text/javascript">
    $(function(){
        $(".leftnav h2").click(function(){
            $(this).next().slideToggle(200);
            $(this).toggleClass("on");
        });
        $(".leftnav ul li a").click(function(){
            $("#a_leader_txt").text($(this).text());
            $(".leftnav ul li a").removeClass("on");
            $(this).addClass("on");
        })
    });
</script>
<div class="admin">

<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <li><a class="button border-main icon-plus-square-o" href="<?php echo url('admin/novel/add'); ?>"> 添加内容</a></li>
            <!--<li>搜索：</li>-->
            <!--<li>首页-->
            <!--<select name="s_ishome" class="input" onchange="changesearch()" style="width:60px; line-height:17px; display:inline-block">-->
            <!--<option value="">选择</option>-->
            <!--<option value="1">是</option>-->
            <!--<option value="0">否</option>-->
            <!--</select>-->
            <!--&nbsp;&nbsp;-->
            <!--推荐-->
            <!--<select name="s_isvouch" class="input" onchange="changesearch()" style="width:60px; line-height:17px;display:inline-block">-->
            <!--<option value="">选择</option>-->
            <!--<option value="1">是</option>-->
            <!--<option value="0">否</option>-->
            <!--</select>-->
            <!--&nbsp;&nbsp;-->
            <!--置顶-->
            <!--<select name="s_istop" class="input" onchange="changesearch()" style="width:60px; line-height:17px;display:inline-block">-->
            <!--<option value="">选择</option>-->
            <!--<option value="1">是</option>-->
            <!--<option value="0">否</option>-->
            <!--</select>-->
            <!--</li>-->
            <!--<li>-->
            <!--<select name="cid" class="input" style="width:200px; line-height:17px;" onchange="changesearch()">-->
            <!--<option value="">请选择分类</option>-->
            <!--<option value="">产品分类</option>-->
            <!--<option value="">产品分类</option>-->
            <!--<option value="">产品分类</option>-->
            <!--<option value="">产品分类</option>-->
            <!--</select>-->
            <!--</li>-->
            <!--<li>-->
            <!--<input type="text" placeholder="请输入搜索关键字" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block"/>-->
            <!--<a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()"> 搜索</a></li>-->
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="10%">排序</th>
            <th>图片</th>
            <th>名称</th>
            <th>属性</th>
            <th>连载</th>
            <th>关键字</th>
            <th>评分</th>
            <th width="10%">更新时间</th>
            <th width="310">操作</th>
        </tr>
        <?php foreach($lists as $key=>$val): ?>
        <tr>
            <td><input type="text" name="sort[1]" value="<?php echo $val['id']; ?>" style="width:50px; text-align:center; border:1px solid #ddd; padding:7px 0;"/></td>
            <td width="10%"><img src="<?php echo $val['cover']; ?>" alt="" width="70"/></td>
            <td><?php echo $val['title']; ?></td>
            <td><font color="#00CC99"><?php echo $val['types']; ?></font></td>
            <td><?php if($val['novel_status']==1): ?>连载中<?php else: ?>已完结<?php endif; ?></td>
            <td><?php echo $val['tags']; ?></td>
            <td><?php echo $val['point']; ?></td>
            <td><?php echo $val['add_time']; ?></td>
            <td>
                <div class="button-group">
                    <a class="button border-main" href="<?php echo url('admin/novel/update',['id'=>$val['id']]); ?>">修改信息</a>
                    <a class="button border-main" href="<?php echo url('admin/novel/novel_list',['id'=>$val['id']]); ?>">章节列表</a>
                    <a class="button border-red" href="javascript:void(0)"><?php if($val['status']): ?>下架<?php else: ?>上架<?php endif; ?></a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="8">
                <?php echo $lists->render(); ?>
            </td>
        </tr>
    </table>
</div>

</div>

</body>
</html>
