layui.use(['layer','table','dropdown'], function(){
  var $ = layui.$    
  var layer = layui.layer;
  var table = layui.table,form = layui.form;
  var dropdown = layui.dropdown;
  get_login();
  
function get_login(){//获取用户状态
    $.post("ajax.php",{act:"get_login"}, function(data) {
            if (data.code != 1) {
                window.location.href='login.php';
            }        
    });
}
$("#btn_logout").on('click',function(){//退出登陆
   $.post("ajax.php",{act:"logout"}, function(data) {
            if (data.code == 1) {
              layer.msg(data.msg, {icon: 1, audio:'1'});
              layer.load();
                setTimeout(function(){
                layer.closeAll('loading');
                get_login();
                }, 1200);
            }else{
              layer.msg(data.msg, {icon: 2, audio:'1'});  
            }       
   });
});
//===========================
});