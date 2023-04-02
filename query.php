<?include 'core/common.php'?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>查询兑换结果</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <meta name="keywords" content="<?=config('keywords')?>">
    <meta name="description" content="<?=config('description')?>">    
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/static/v1/html5shiv.min.js"></script>
    <script src="/static/v1/respond.min.js"></script>
    <![endif]-->
<style>
.table_ui{
  width: 100%;
  overflow: hidden;
  overflow-x: auto;
  white-space: nowrap; 
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
            <a class="navbar-brand" href="/index.php">查询兑换结果</a>
        </div><!-- /.navbar-header -->
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/index.php"><span class="glyphicon glyphicon-list"></span> 礼品兑换</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->
<div class="container" style="padding-top: 70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">查询</h3>
            </div>
            <div class="panel-body">
                <form action="?" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">QQ</label>
                        <div class="col-sm-10">
                            <input type="text" name="qq" id="qq" class="form-control">
                            <code>暂时不支持微信查询</code>
                            <code>兑换后系统会在0-24小时内处理完毕，请耐心等待</code>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="button" id="btn3" value="查询结果" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>
                <div id="resultShow" class="table_ui">
                <table class="table table-bordered " id="selse_table_user">
                    <thead>
                        <tr><th>下单QQ</th><th>订单状态</th><th>使用卡密</th><th>下单时间</th><th>卡密状态</th></tr>
                      </thead>
                      <tbody>
                      </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/assets/layui/layui.js"></script>
<script>
    $(function (){
        $("#btn3").click(function (){
            let qq = $("#qq").val();
            let load = layer.load();
            if (!qq) {
                layer.alert('输入账号');
                layer.close(load);
                return false;
            }
            // 提交
            $.post("ajax.php",{act:"check",qq:qq},function(d){
                layer.close(load);
                if (d.code == 0)
                {
                    layer.alert(d.msg);
                    $("#selse_table_user tr:not(:first)").empty("");
                    for(let i = 0;i<d.data.length;i++)
                    {
                        let order = d.data[i];
                        var active ="";
                        if(order.active==1){active="<span style='color:red;'>已使用</span>"}else{active="<span style='color:#00FF00;'>未使用</span>"}
                        $('#selse_table_user').append(`<tr><th>${order.qq}</th><th>${order.msg}</th><th>${order.card}</th><th>${order.time}</th><th>${active}</th></tr>`);
                    }
                    $("#resultShow").show();
                    return true;
                } else {
                    layer.alert(d.msg);
                    return false;
                }
            },'json');
        });
    });
</script>
</html>