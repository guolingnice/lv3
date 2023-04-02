<?include'../core/common.php'?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?=config('title')?>-后台管理</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href="../assets/layui/css/layui.css" rel="stylesheet">
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
}
.user_photo{
   width: 30px; 
   height: 30px;
}
</style>    
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
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> 返回首页</a></li>
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
                        <li ><a href="card_list.php"><span class="glyphicon glyphicon-credit-card"></span> 卡密列表</a></li>
                        
                        <li><a href="card_out.php"><span class="glyphicon glyphicon-credit-card"></span> 导出卡密</a></li>
                    </ul>
                </li>                
                <li><a href="log.php"><span class="glyphicon glyphicon-list-alt"></span> 操作日志</a></li>
                <li class="active" ><a href="set_up.php"><span class="glyphicon glyphicon-wrench"></span> 站点管理</a></li>
                <li><a href="#" id="btn_logout"><span class="glyphicon glyphicon-log-out"></span> 退出登录</a></li>
            </ul>
        </div>
    </div>
</nav> 
<div class="container" style="padding-top: 70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">站点信息</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal layui-form" action="" lay-filter="set_up">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">站点名称</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="title" placeholder="站点名称" value="<?=config('title')?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">站点关键词</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="keywords" placeholder="站点关键词" value="<?=config('keywords')?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">站点介绍</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="description" placeholder="站点介绍" value="<?=config('keywords')?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">站点ICP</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="icp" placeholder="站点ICP" value="<?=config('icp')?>">
                    </div>
                  </div>   
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">站点版权</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="copyright" placeholder="站点版权" value="<?=config('copyright')?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">管理员账号</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="admin_user" placeholder="管理员账号" value="<?=q_md5code($_COOKIE['admin_user'])?>">
                    </div>
                  </div>  
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">管理员密码</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="admin_pass" placeholder="管理员密码" value="">
                    </div>
                  </div>                   
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" id="btn_set_up" class="btn btn-default">确认修改</button>
                    </div>
                  </div>
                </form>                
            </div>
        </div>
    </div>
</div>
</div>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin.js"></script>
<script>
layui.use(['form', 'util', 'laydate'], function(){
  var form = layui.form;
  var layer = layui.layer;
  var util = layui.util;
  layui.$('#btn_set_up').on('click', function(){
    var data = form.val('set_up');
    var json_data = JSON.stringify(data);
    $.post("ajax.php",{act:"set_config",data:json_data}, function(data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, audio:'1'}); 
        }else{
            layer.msg(data.msg, {icon: 2, audio:'1'}); 
        }     
    },"json");
  });  
});    
</script>  
</body>
</html>