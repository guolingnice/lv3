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
   width: 50px; 
   height: 50px;
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
                <li role="presentation" class="dropdown active">
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
                <li><a href="set_up.php"><span class="glyphicon glyphicon-wrench"></span> 站点管理</a></li>
                <li><a href="#" id="btn_logout"><span class="glyphicon glyphicon-log-out"></span> 退出登录</a></li>
            </ul>
        </div>
    </div>
</nav> 
<div class="container" style="padding-top: 70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">用户领取记录列表</h3>
            </div>
            <div class="panel-body">
                 <table class="layui-hide" id="user_list_log" lay-filter="user_list_log"></table>
            </div>
        </div>
    </div>
</div>
</div>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin.js"></script>
<script>
layui.use(['layer','table','dropdown'], function(){
  var $ = layui.$    
  var layer = layui.layer;
  var table = layui.table,form = layui.form;
  var dropdown = layui.dropdown;
get_user_log();
function get_user_log(){
 table.render({
    elem: '#user_list_log'
    ,url:'ajax.php'
    ,method:"post"
    ,where:{act:"get_user_log"}
    ,toolbar: '#toolbarDemo'
    ,defaultToolbar: ['filter', 'exports', 'print']
    ,height: 'full-350'
    ,cellMinWidth: 80
    ,page: true
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field:'id', width:60, title: 'ID'}
      ,{field:'qq', width:110, title: '领取QQ'}
      ,{field:'data', title:'领取业务 ', width:120}
      ,{field:'msg', title:'领取状态 ', width:120}
      ,{field:'card', width:150, title: '所用卡密'}
      ,{field:'time', title:'使用时间', width: 165}
    ]]
    ,done: function(){
      var id = this.id;
 
    }
    ,error: function(res, msg){
      console.log(res, msg);
    }
  });
}
});    
</script>
</body>
</html>