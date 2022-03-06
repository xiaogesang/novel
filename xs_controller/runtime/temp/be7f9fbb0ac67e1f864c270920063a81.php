<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"D:\WWW\xs_controller\public/../application/admin\view\user\lists.html";i:1617247517;s:55:"D:\WWW\xs_controller\application\admin\view\layout.html";i:1617248326;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>
用户列表
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
            <li></li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="100">ID</th>
            <th>名称</th>
            <th width="10%">注册时间</th>
            <th width="310">操作</th>
        </tr>
        <?php foreach($lists as $key=>$val): ?>
        <tr>
            <td><input type="text" name="sort[1]" value="<?php echo $val['id']; ?>" style="width:50px; text-align:center; border:1px solid #ddd; padding:7px 0;"/></td>
            <td><?php echo $val['phone']; ?></td>
            <td><?php echo $val['add_time']; ?></td>
            <td>
                <div class="button-group"><a class="change button <?php if($val['status']==1): ?> border-red <?php else: ?> border-main <?php endif; ?>" data-url="<?php echo url('admin/user/change',['id'=>$val['id']]); ?>" href="javascript:void(0)"><?php if($val['status']==1): ?>禁用<?php else: ?>解禁<?php endif; ?></a></div>
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

<script>
    $(function(){
       $('a.change').on('click',function(){
            var text = $(this).text();
            if (confirm('确认'+text+'？')==true){
                var url = $(this).data('url');
                location = url;
            }
       });
    });
</script>

</body>
</html>
