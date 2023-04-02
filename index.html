<?include 'core/common.php'?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?=config('title')?></title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!--<script src="/assets/js/npm.js"></script>-->
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.min.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
<style>
.user_photo{
   width: 25px; 
   height: 25px;
   border-radius: 50%;
}    
</style>    
</head>
<body>  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">导航按钮</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.php"><?=config('title')?></a>
        </div><!-- /.navbar-header -->
        <div id="navbar" class="collapse navbar-collapse" >
            <ul class="nav navbar-nav navbar-right">
                <li id="state1">
                    <a href="/qrlogin.php"><span class="glyphicon glyphicon-list"></span> 未登录账号</a>
                </li>
                <li id="state2" class="active">
                    <a  href="#"><b id="user_info"> 已登录</b></a>
                </li>
                <li id="state3">
                    <a href="#" id="logout"> 退出登录</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->
<div class="container" style="padding-top: 70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">扣扣账号:<b id="uin"></b></h3>
            </div>
            <div class="panel-body">
                <form action="?" class="form-horizontal" role="form">
                    <div class="form-group">
                        <input type="hidden" id="qq" value="" />
                        <label class="col-sm-2 control-label">卡密</label>
                        <div class="col-sm-10">
                            <input type="text" name="card" id="card" class="form-control" >
                            <code>兑换后系统会在0-24小时内处理完毕，请耐心等待</code>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="button" id="btn3" value="确定兑换" class="btn btn-primary form-control">
                            <p></p>
                            <input type="button" onclick="window.location.href='/query.php';" value="查询兑换结果" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
</div>
</body>
<script src="/assets/layui/layui.js"></script>
<script>
    get_login();
    function get_login(){
        $.post("ajax.php",{act:"get_login"}, function(data) {
            if(data.code==1){
                $("#state1").hide();
                $("#state2").show();
                $("#state3").show();
                $('#uin').html(data.qq);
                $('#user_info').html("<img class='user_photo' src='"+data.pic+"'> "+data.username+" 已登录")
            }else{
                $('#uin').html("");
                $("#state1").show();
                $("#state2").hide();
                $("#state3").hide();
            }
        },"json");
    }
    $(function (){
        $("#btn3").click(function (){
            let qq = $("#uin").html();
            let km = $("#card").val();
            let load = layer.load();
            if (!qq) {
                layer.alert('请先登录账号',function (){
                    window.location.href = "/qrlogin.php";
                });
                layer.close(load);
                return false;
            }
            // 提交
            $.post("ajax.php",{act:"collar",qq:qq,card:km},function(d){
                layer.close(load);
                if (d.code == 1)
                {
                    layer.alert(d.msg);
                    return true;
                } else {
                    layer.alert(d.msg);
                    return false;
                }
            },'json');
        });
    });
    $("#logout").click(function (){
        $.post("ajax.php",{act:"logout"}, function(data) {
            if(data.code==1){
                layer.msg(data.msg);
                $('#uin').html("");
                get_login();
            }
        },"json");        
    });
    function getCookie(name)
    {
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
    }
</script>
</html>