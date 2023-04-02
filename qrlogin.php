<?include 'core/common.php'?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>扫码登录</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">    
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!--<script src="/assets/js/npm.js"></script>-->
    <!--[if lt IE 9]>
    <script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/js/qrlogin.js?v=10"></script>
</head>
<body>
<div class="container">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
                扫码登录</h3>
            </div>
            <div class="panel-body" style="text-align: center;">
                <div class="list-group">
                    <div class="list-group-item">请使用你要领取账号扫码登录，完成登录后请及时绑定卡密</div>
                    <div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
                        <span id="loginmsg">使用扣扣手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
                    </div>
                    <div class="list-group-item" id="qrimg">
                    </div>
                    <div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurlnew()" class="btn btn-warning btn-block">跳转快捷登录</button></div>
                    <div class="list-group-item" id="submit"><a href="#" onclick="qrlogin()" class="btn btn-block btn-success">完成登录，点此验证</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>