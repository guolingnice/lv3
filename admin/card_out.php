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
                <li role="presentation" class="dropdown ">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> 用户管理<span class="caret"></span></a>
                    <ul class="nav navbar-nav navbar-right dropdown-menu">
                        <li><a href="user_list.php"><span class="glyphicon glyphicon-user"></span> 用户列表</a></li>
                        <li><a href="user_receive.php"><span class="glyphicon glyphicon-user"></span> 领取记录</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown active">
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
    <div class="row">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">导出卡密</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline">
                  <div class="form-group">
                    <label for="exampleInputName2">导出数量</label>
                    <input type="number" class="form-control" id="out_card_num" placeholder="数量">
                  </div>
                  <button type="button" id="btn_out_card" class="btn btn-info">立即导出</button>
                </form>
                </br>
                <h4>剩余可导出卡密 <span style="color:red" id="surplus"><?=statistics("out_card_list")?></span> 张</h4>
            </div>
        </div>    
    </div>
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">卡密列表</h3>
            </div>
            <div class="panel-body">
                <button type="button" id="btn_copy_card" class="btn btn-info btn-block">复制卡密</button>
                <textarea id="out_card_list" class="form-control" rows="20"></textarea>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin.js"></script>
<script>
layui.use('layer', function(){
  var $ = layui.$    
  var layer = layui.layer;
$('#btn_out_card').on('click',function(){
    var num = $('#out_card_num').val();
    $.post("ajax.php",{act:"out_card",num:num}, function(data) {
        if (data.code == 0) {
            var key_data='';
            for(var i=0;i<num;i++){
                   key_data += data.data[i] + "\n" 
            }
            $('#out_card_list').val(key_data);
            $('#surplus').html(data.surplus);
            layer.msg(data.msg, {icon: 1, audio:'1'}); 
        }else{
           layer.msg(data.msg, {icon: 2, audio:'1'});  
        }       
    });        
});
$("#btn_copy_card").on('click',function(){
    $('#out_card_list').val();
    $('#out_card_list').select();
    var state = document.execCommand('copy');
    if(state){layer.msg('复制成功！', {icon: 1, audio:'1'});}else{layer.msg('复制失败！', {icon: 1, audio:'1'});}
});
});
</script>
</body>
</html>