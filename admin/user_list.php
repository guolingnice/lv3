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
                <h3 class="panel-title">用户列表</h3>
            </div>
            <div class="panel-body">
                <table class="layui-hide" id="user_list" lay-filter="user_list"></table>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/html" id="activeTpl">
  <input type="checkbox" name="active" value="{{d.uid}}" lay-skin="switch" lay-text="正常|封禁" lay-filter="activeDemo" {{ d.active == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="picTpl">
    <img class='user_photo' src='{{d.pic}}'>
</script>
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/js/admin.js"></script>
<script>
layui.use(['layer','table','dropdown'], function(){
  var $ = layui.$    
  var layer = layui.layer;
  var table = layui.table,form = layui.form;
  var dropdown = layui.dropdown;
get_user();
function get_user(){
 table.render({
    elem: '#user_list'
    ,url:'ajax.php'
    ,method:"post"
    ,where:{act:"get_user"}
    ,toolbar: '#toolbarDemo'
    ,defaultToolbar: ['filter', 'exports', 'print']
    ,height: 'full-350'
    ,cellMinWidth: 80
    ,page: true
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field:'uid', width:60, title: 'ID'}
      ,{field:'qq', width:110, title: 'QQ'}
      ,{field:'name', title:'昵称 ', width:100}
      ,{field:'pic', width:80, title: '头像', templet: '#picTpl'}
      ,{field:'city', width:155, title: '来源', minWidth:150, templet: '#cityTpl'}
      ,{field:'ip', title:'IP', width: 130}
      ,{field:'time', title:'登陆时间', width: 165}
      ,{field:'active', title:'状态', width: 130, templet: '#activeTpl'}
      ,{title:'操作', width: 125, minWidth: 125, toolbar: '#barDemo'}
    ]]
    ,done: function(){
      var id = this.id;
 
    }
    ,error: function(res, msg){
      console.log(res, msg);
    }
  });
    //触发单元格工具事件
  table.on('tool(user_list)', function(obj){ // 双击 toolDouble
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        obj.del();
        layer.close(index);
            $.ajax({
               type: "POST",
               url:'ajax.php',
               data: {act:"del_user",uid:data.uid},
               dataType: "json",        
               success:function(data){
                   if(data.code == 0){
                       layer.msg(data.msg, {icon: 1, audio:'1'});
                   }else{
                       layer.msg(data.msg, {icon: 2, audio:'1'}); 
                   }
               }
           });
      });   
    }
  });    
  
  form.on('switch(activeDemo)', function(obj){
      var uid = this.value;
      var type = obj.elem.checked;
      var active=1;
      if(type==true){active=1;}else{active=0;}
    $.ajax({
        type: "POST",
        url:'ajax.php',
        data: {act:"set_user_active",uid:uid,type:active},
        dataType: "json",        
        success:function(data){
            if(data.code == 0){
                layer.msg(data.msg, {icon: 1, audio:'1'});
            }else{
                layer.msg(data.msg, {icon: 2, audio:'1'}); 
            }
        },
        error: function() {
            layer.msg('获取规则失败');
        }
    });      
  });   

}    
});    
</script>
</body>
</html>