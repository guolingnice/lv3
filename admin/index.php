<?include'../core/common.php';
$admin_row = $DB->get_row("SELECT * FROM qmn_admin WHERE id='1' limit 1");
?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?=config('title')?>-后台管理</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>    
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.min.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
<style>
body{
    background-color: #dddddd;
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
            <a class="navbar-brand" href="login.php">后台管理系统</a>
        </div><!-- /.navbar-header -->
        <div id="navbar" class="collapse navbar-collapse" >
            <ul class="nav nav-pills navbar-nav navbar-right">
                <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> 返回首页</a></li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> 用户管理<span class="caret"></span></a>
                    <ul class="nav navbar-nav navbar-right dropdown-menu">
                        <li><a href="user_list.php"><span class="glyphicon glyphicon-user"></span> 用户列表</a></li>
                        <li><a href="user_receive.php"><span class="glyphicon glyphicon-user"></span> 领取记录</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-credit-card"></span> 卡密管理<span class="caret"></span></a>
                    <ul class="nav navbar-nav navbar-right dropdown-menu">
                        <li><a href="card_list.php"><span class="glyphicon glyphicon-credit-card"></span> 卡密列表</a></li>
                        
                        <li><a href="card_out.php"><span class="glyphicon glyphicon-credit-card"></span> 导出卡密</a></li>
                    </ul>
                </li>                
                <li><a href="log.php"><span class="glyphicon glyphicon-list-alt"></span> 操作日志</a></li>
                <li><a href="set_up.php"><span class="glyphicon glyphicon-wrench"></span> 站点管理</a></li>
                <li><a href="#" id="btn_logout"><span class="glyphicon glyphicon-log-out"></span> 退出登录</a></li>
            </ul>
        </div>
    </div>
</nav> 
<div class="container" style="padding-top: 70px;">
    <div class="row">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="row text">
            <div class="col-xs-6 col-sm-3 col-lg-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                         <h3 class="panel-title"><i class="glyphicon glyphicon-user"> 用户总数</i></h3>
                   </div>
                    <div class="panel-body">
                        <h4><?=statistics("user")?> 位</h4>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3 col-lg-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                         <h3 class="panel-title"><i class="glyphicon glyphicon-credit-card"> 可用卡密</i></h3>
                   </div>                    
                    <div class="panel-body">
                        <h4><?=statistics("card")?> 张</h4>
                    </div>
                </div>
            </div>            
            <div class="col-xs-6 col-sm-3 col-lg-3">
                <div class="panel  panel-info">
                    <div class="panel-heading">
                         <h3 class="panel-title"><i class="glyphicon glyphicon-credit-card"> 卡密总数</i></h3>
                   </div>                     
                    <div class="panel-body">
                        <h4><?=statistics("card_list")?> 张</h4>
                    </div>
                </div>
            </div>            
            <div class="col-xs-6 col-sm-3 col-lg-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                         <h3 class="panel-title"><i class="glyphicon glyphicon-gift"> 领取总数</i></h3>
                   </div> 
                    <div class="panel-body">
                        <h4><?=statistics("use")?> 次</h4>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">管理员信息</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item">管理员账号：<?=$admin_row['user']?></li>
                  <li class="list-group-item">管理员类型: 站长</li>
                  <li class="list-group-item">快捷操作：
                       <button type="button" onclick="location.href='card_list.php'" class="btn btn-primary btn-xs">卡密列表</button>
                       <button type="button" onclick="location.href='card_out.php'" class="btn btn-success btn-xs">导出卡密</button>
                       <button type="button" onclick="location.href='log.php'" class="btn btn-warning btn-xs">查看日志</button>
                  </li>
                </ul>
            </div>
        </div>
    </div>    
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">站点信息</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item">操作环境：<?=php_uname('s')?></li>
                  <li class="list-group-item">运行环境：<?=$_SERVER["SERVER_SOFTWARE"]?></li>
                  <li class="list-group-item">php版本：<?=PHP_VERSION?></li>
                  <li class="list-group-item">程序版本：V1.0</li>
                  <li class="list-group-item">作者：青木倪</li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin.js?v=<?=rand(1,9999)?>"></script>
</body>
</html>