<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:51:"D:\WWW\xs_controller\thinkphp\tpl\dispatch_jump.tpl";i:1563355103;}*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding:0; margin:0; }

        body{ background:#fff; font-family:"Microsoft Yahei", "Helvetica Neue", Helvetica, Arial, sans-serif; color:#333; font-size:16px; }

        .system-message{ padding:24px 48px; }

        .system-message h1{ font-size:100px; font-weight:normal; line-height:120px; margin-bottom:12px; }

        .system-message .jump{ padding-top:10px; }

        .system-message .jump a{ color:#333; }

        .system-message .success, .system-message .error{ line-height:1.8em; font-size:36px; }

        .system-message .detail{ font-size:12px; line-height:20px; margin-top:12px; display:none; }
    </style>
</head>
<body>
    <a href="<?php echo($url); ?>" id="alert" ><?php echo(strip_tags($msg)); ?></a>
    <script type="text/javascript">
        var a = document.getElementById('alert');
        var url = a.getAttribute("href");
        var text = a.innerText;
        alert(text);
        location = url;
    </script>
</body>
</html>
