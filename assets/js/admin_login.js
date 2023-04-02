layui.use(['form', 'util'], function(){
  var $ = layui.$    
  var form = layui.form;
  var layer = layui.layer;
  var util = layui.util;
get_login();
function get_login(){
    $.ajax({
        type: "POST",
        url:'ajax.php',
        data: {act:"get_login"},
        dataType: "json",
        success: function(data) {
            if (data.code == 1) {
                window.location.href='index.php';
            }
        },
        error: function() {
            layer.msg("服务器错误！", {icon: 2, audio:'1'});
        }
    });
}
$('#btn_login').on('click',function(){
    var user = $('#login_user').val();
    var pass = $('#login_pass').val();
    $.post("ajax.php",{act:"login",user:user,pass:pass}, function(data) {
            if (data.code == 1) {
                layer.alert(data.msg, {icon: 1, audio:'1'});
                layer.load();
                setTimeout(function(){
                layer.closeAll('loading');
                window.location.href='index.php';
                }, 1200);
                
            }else{
                layer.msg(data.msg, {icon: 2, audio:'1'});
            }
    });
});


});  