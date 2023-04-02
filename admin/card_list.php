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
                <li role="presentation" class="dropdown">
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
                <h3 class="panel-title">卡密操作</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline">
                  <div class="form-group">
                    <label for="exampleInputName2">生成卡密数量</label>
                    <input type="text" class="form-control" id="add_card_num" placeholder="数量">
                  </div>
                  <button type="button" id="btn_add_card" class="btn btn-info">立即生成</button>
                </form>                
            </div>
        </div>    
    </div>
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h3 class="panel-title">卡密列表</h3>
            </div>
            <div class="panel-body">
                <table class="layui-hide" id="card_list" lay-filter="card_list"></table>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<script type="text/html" id="toolbarDemo">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del_cards">批量删除</a>
</script>
<script type="text/html" id="card_userTpl">
  {{# if(d.qq ==''){ }}
      <span style="color: #F581B1;">未使用</span>
  {{#  } else { }}
    {{ d.qq }}      
  {{#  } }}
</script>
<script type="text/html" id="card_outTpl">
  <input type="checkbox" name="out" value="{{d.cid}}" lay-skin="switch" lay-text="未导出|已导出" lay-filter="outDemo" {{ d.card_out == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="card_activeTpl">
  <input type="checkbox" name="active" value="{{d.cid}}" lay-skin="switch" lay-text="未使用|已使用" lay-filter="activeDemo" {{ d.active == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="card_barDemo">
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
get_card_list();
function get_card_list(){
 table.render({
    elem: '#card_list'
    ,url:'ajax.php'
    ,method:"post"
    ,where:{act:"get_card_list"}
    ,toolbar: '#toolbarDemo'
    ,defaultToolbar: ['filter', 'exports', 'print']
    ,height: 'full-350'
    ,cellMinWidth: 80
    ,page: true
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field:'cid', width:100, title: 'ID'}
      ,{field:'msg', width:260, title: '卡密内容'}
      ,{field:'uid', title:'领取用户ID ', width:120, templet: '#card_userTpl'}
      ,{field:'time', title:'使用时间 ', width:120}
      ,{field:'card_out', width:150, title: '导出状态', templet: '#card_outTpl'}
      ,{field:'active', title:'使用状态', width: 165, templet: '#card_activeTpl'}
      ,{title:'操作', width: 125, minWidth: 125, toolbar: '#card_barDemo'}
    ]]
    ,done: function(){
      var id = this.id;
 
    }
    ,error: function(res, msg){
      console.log(res, msg);
    }
  });
  
  table.on('toolbar(card_list)', function(obj){
    var id = obj.config.id;
    var checkStatus = table.checkStatus(id);
    var othis = lay(this);
    switch(obj.event){
      case 'del_cards':
        var data = checkStatus.data;
        layer.confirm('真的删除行么', function(index){
           layer.close(index);
        // console.log(getData);
           var data_json = JSON.stringify(data);
           $.post("ajax.php",{act:"del_cards",data:data_json}, function(data) {
               if (data.code == 1) {
                   table.reload("card_list");
                   layer.msg(data.msg, {icon: 1, audio:'1'}); 
               }        
           },"json");
        });  
      break;
    };
  });  
  
  table.on('tool(card_list)', function(obj){ // 双击 toolDouble
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        obj.del();
        layer.close(index);
           $.post("ajax.php",{act:"del_card",cid:data.cid}, function(data) {
                if(data.code == 0){
                    table.reload("card_list");
                    layer.msg(data.msg, {icon: 1, audio:'1'});
                }else{
                       layer.msg(data.msg, {icon: 2, audio:'1'}); 
                }               
           },"json");
      });   
    }
  });  
  form.on('switch(activeDemo)', function(obj){
      var cid = this.value;
      var type = obj.elem.checked;
      var active=1;
      if(type==true){active=1;}else{active=0;}
           $.post("ajax.php",{act:"set_card_active",cid:cid,type:active}, function(data) {
                if(data.code == 0){
                    // table.reload("card_list");
                    layer.msg(data.msg, {icon: 1, audio:'1'});
                }else{
                       layer.msg(data.msg, {icon: 2, audio:'1'}); 
                }               
           },"json");
  });
  form.on('switch(outDemo)', function(obj){
      var cid = this.value;
      var type = obj.elem.checked;
      var out=1;
      if(type==true){out=1;}else{out=0;}
           $.post("ajax.php",{act:"set_card_out",cid:cid,type:out}, function(data) {
                if(data.code == 0){
                    // table.reload("card_list");
                    layer.msg(data.msg, {icon: 1, audio:'1'});
                }else{
                       layer.msg(data.msg, {icon: 2, audio:'1'}); 
                }
           },"json");     
  });  
  
}

$('#btn_add_card').on('click',function(){
    var num = $('#add_card_num').val();
    $.post("ajax.php",{act:"add_card",num:num}, function(data) {
            if (data.code == 1) {
                table.reload("card_list");
                layer.msg(data.msg, {icon: 1, audio:'1'}); 
            }        
    });    
});
});    
</script>
</body>
</html>