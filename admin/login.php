<?include'../core/common.php'?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?=config('title')?>-登陆后台管理</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">    
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.min.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
<style>
body{
    background-color: #eeeeee;
}
.text{
    text-align: center;
}</style>    
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">导航按钮</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="login.php">后台登录</a>
        </div><!-- /.navbar-header -->
        <div id="navbar" class="collapse navbar-collapse" >
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../"><span class="glyphicon glyphicon-home"></span> 返回首页</a>
                </li>
            </ul>
        </div>
    </div>
</nav> 
<div class="container" style="padding-top: 70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">登录管理员账号</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">管理员账号</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="login_user" placeholder="请输入您的管理员账号">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">管理员密码</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="login_pass" placeholder="请输入您的管理员密码">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" id="btn_login" class="btn btn-primary btn-sm btn-lg btn-block">立即登录</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin_login.js?v=21"></script>
</body>
</html>