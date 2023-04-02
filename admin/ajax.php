<?
include('../core/common.php');
error_reporting(0);
header("content-type:text/json;charset=UTF-8");
$admin_user = q_md5code($_COOKIE['admin_user']);
$admin_pass = q_md5code($_COOKIE['admin_pass']);
$act = $_POST['act'];
switch ($act) {
    case 'get_login'://获取管理员登录信息
        $admin_row = $DB->get_row("SELECT * FROM qmn_admin WHERE user='".$admin_user."' limit 1");
        if($admin_user=='' || $admin_pass==''){
            $json = array("code"=>0,"success"=>false,"msg"=>"未登录！");
            echo echo_json($json);            
        }else{
            if($admin_row==""){
                $json = array("code"=>0,"success"=>false,"msg"=>"账号出错！");
                echo echo_json($json);                 
            }else if($admin_row['user']==$admin_user && $admin_row['pass'] != $admin_pass){
                $json = array("code"=>2,"success"=>false,"msg"=>"密码错误！");
                echo echo_json($json);
            }else{
                $json = array("code"=>1,"success"=>true,"msg"=>"已登录！","admin_user"=>$admin_user,"username"=>$admin_row['name']);
                echo echo_json($json);                
            }
        }
    break;  
    case 'login'://管理员登录
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $admin_row = $DB->get_row("SELECT * FROM qmn_admin WHERE user='".$user."' limit 1");
        if($user=='' && $pass==''&& $captcha==''){
            $json = array("code"=>3,"success"=>false,"msg"=>"所需内容不完整！");
            echo echo_json($json);
        }else if($admin_row['user']!=$user){
            $json = array("code"=>0,"success"=>false,"msg"=>"您所登陆的账号，还未注册！");
            echo echo_json($json);
        }else{
            if($admin_row['pass']!=$pass){
                add_adminlog($user,"《登陆管理员》","登陆失败,密码输入错误！");
                $json = array("code"=>2,"success"=>false,"msg"=>"抱歉，密码错误！");
                echo echo_json($json);
            }else if($admin_row['active']==0){
                $json = array("code"=>-1,"success"=>false,"msg"=>"抱歉,您的账号已被封禁！");
                echo echo_json($json);
            }else{
                $clientip = real_ip();//操作IP
                $city = get_ip_city($clientip);//操作来源
                setcookie("admin_user",z_md5code($user), time() + 604800);
                setcookie("admin_pass",z_md5code($pass), time() + 604800);
                add_adminlog($user,"《登陆管理员后台》","登陆成功！");
                $DB->query("UPDATE `qmn_admin` SET `ip`='".$clientip."',`city`='".$city."',`time`='".$date."' WHERE `user`='".$user."'");//修改管理员登录状态
                $json = array("code"=>1,"success"=>true ,"msg"=>"恭喜,登录成功！");
                echo echo_json($json);
            }
        }
    break;
    case 'logout'://登出管理员账号
        setcookie("admin_user",'', time() - 604800);
        setcookie("admin_pass",'', time() - 604800);
        $json = array("code"=>1,"success"=>true,"msg"=>"退出账号成功！");
        echo echo_json($json);
    break;
    case 'get_user'://获取用户列表
           $g_page = $_POST['page'];
           $limit = $_POST['limit'];
            $app_count=$DB->count("SELECT count(*) from qmn_user");
            $pagesize = $limit;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {$pages++;}
            if ($g_page=="0") {$page = 1;}
            else if (isset($g_page)) {$page = intval($g_page);} else {$page = 1;}
            $offset = $pagesize * ($page - 1);     
           $sql = "SELECT * FROM qmn_user order by uid DESC limit $offset,$pagesize";
           $result = $DB->query($sql);
           $jarr = array();
           while ($rows=mysqli_fetch_array($result,MYSQL_ASSOC)){
               $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
               for($i=0;$i<$count;$i++){
                   unset($rows[$i]);//删除冗余数据
	 	       }
	 	       $user_data = array("uid"=>$rows['uid'],"qq"=>$rows['qq'],"name"=>$rows['name'],"pic"=>$rows['pic'],"city"=>$rows['city'],"ip"=>$rows['ip'],"time"=>$rows['time'],"active"=>$rows['active']);
	 	       array_push($jarr,$user_data);
	 	       
           }
            $json = array(
                "code"=>0,
                "msg"=>"获取成功！",
                "count"=> $app_count,
                "data"=>$jarr
            );
            echo echo_json($json);
    break;
    case 'del_user':
       if(islogin_admin($admin_user,$admin_pass)==true){
          $uid = $_POST['uid'];
          if($uid!=''){
               add_adminlog("admin","《删除用户》","删除了用户，ID：".$uid."！");
               $DB->query("DELETE FROM `qmn_user` WHERE uid='".$uid."'");
               $json = array("code"=>0,"success"=>true,"msg"=>"删除用户成功！");
               echo echo_json($json);            
          }else{
               $json = array("code"=>2,"success"=>false,"msg"=>"删除失败，请先选择一个用户！");
               echo echo_json($json);  
          }           
       }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);              
       }
    break;    
    case 'set_user_active': //修改用户状态
        if(islogin_admin($admin_user,$admin_pass)==true){
           $uid = $_POST['uid'];
           $type = $_POST['type'];
           if($type==1){
               $active = 1;
               $DB->query("UPDATE `qmn_user` SET `active`='".$active."' WHERE `uid`='".$uid."'");
               $json = array("code"=>0,"msg"=>"修改成功，已恢复用户状态！");
                echo echo_json($json); 
           }else{
               $active = 0;
               $DB->query("UPDATE `qmn_user` SET `active`='".$active."' WHERE `uid`='".$uid."'");
               $json = array("code"=>0,"msg"=>"修改成功,已封禁用户！");
               echo echo_json($json); 
           }            
        }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);             
        }

    break;
    case 'get_user_log'://获取用户领取列表
           $g_page = $_POST['page'];
           $limit = $_POST['limit'];
            $app_count=$DB->count("SELECT count(*) from qmn_user_log");
            $pagesize = $limit;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {$pages++;}
            if ($g_page=="0") {$page = 1;}
            else if (isset($g_page)) {$page = intval($g_page);} else {$page = 1;}
            $offset = $pagesize * ($page - 1);     
           $sql = "SELECT * FROM qmn_user_log order by id DESC limit $offset,$pagesize";
           $result = $DB->query($sql);
           $jarr = array();
           while ($rows=mysqli_fetch_array($result,MYSQL_ASSOC)){
               $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
               for($i=0;$i<$count;$i++){
                   unset($rows[$i]);//删除冗余数据
	 	       }
	 	       array_push($jarr,$rows);
	 	       
           }
            $json = array(
                "code"=>0,
                "msg"=>"获取成功！",
                "count"=> $app_count,
                "data"=>$jarr
            );
            echo echo_json($json);
    break;
    case 'get_card_list'://获取卡密列表
           $g_page = $_POST['page'];
           $limit = $_POST['limit'];
            $app_count=$DB->count("SELECT count(*) from qmn_card");
            $pagesize = $limit;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {$pages++;}
            if ($g_page=="0") {$page = 1;}
            else if (isset($g_page)) {$page = intval($g_page);} else {$page = 1;}
            $offset = $pagesize * ($page - 1);     
           $sql = "SELECT * FROM qmn_card order by cid DESC limit $offset,$pagesize";
           $result = $DB->query($sql);
           $jarr = array();
           while ($rows=mysqli_fetch_array($result,MYSQL_ASSOC)){
               $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
               for($i=0;$i<$count;$i++){
                   unset($rows[$i]);//删除冗余数据
	 	       }
	 	       array_push($jarr,$rows);
	 	       
           }
            $json = array(
                "code"=>0,
                "msg"=>"获取成功！",
                "count"=> $app_count,
                "data"=>$jarr
            );
            echo echo_json($json);
    break; 
    case 'del_card':
       if(islogin_admin($admin_user,$admin_pass)==true){
          $cid = $_POST['cid'];
          $card_row = $DB->get_row("SELECT * FROM qmn_card WHERE cid='".$cid."' limit 1");
          if($cid!=''){
               add_adminlog("admin","《删除卡密》","删除了卡密《".$card_row['msg']."》！");
               $DB->query("DELETE FROM `qmn_card` WHERE cid='".$cid."'");
               $json = array("code"=>0,"success"=>true,"msg"=>"删除卡密成功！");
               echo echo_json($json);            
          }else{
               $json = array("code"=>2,"success"=>false,"msg"=>"删除失败，请先选择一个卡密！");
               echo echo_json($json);  
          }           
       }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);              
       }
    break; 
    case 'del_cards':
       if(islogin_admin($admin_user,$admin_pass)==true){
          $data = $_POST['data'];
          $data = json_decode($data,true);
          $num = count($data);
          if($data!=''){
              for($i=0;$i<$num;$i++){
                  $DB->query("DELETE FROM `qmn_card` WHERE cid='".$data[$i]['cid']."'");
              }
               add_adminlog("admin","《删除卡密》","成功删除了卡密".$num."张卡密！");
               $json = array("code"=>1,"success"=>true,"msg"=>"成功删除了卡密".$num."张卡密！");
               echo echo_json($json);            
          }else{
               $json = array("code"=>2,"success"=>false,"msg"=>"删除失败，请先选择一个卡密！");
               echo echo_json($json);  
          }           
       }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);              
       }
    break;
    case 'set_card_active': //修改卡密状态
        if(islogin_admin($admin_user,$admin_pass)==true){
           $cid = $_POST['cid'];
           $type = $_POST['type'];
           if($type==0){$active = 1;$msg = "修改成功，改为已使用！";
           }else{$active = 0;$msg ="修改成功，改为未使用！";}  
           $sql = "UPDATE `qmn_card` SET `active`='".$active."' WHERE `cid`='".$cid."'";
           if($DB->query($sql)){
               $json = array("code"=>0,"msg"=>$msg);
               echo echo_json($json);
           }else{
              $json = array("code"=>3,"msg"=>"修改失败！");
               echo echo_json($json);                
           }
        }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);             
        }
    break;
    case 'set_card_out': //修改卡密状态
        if(islogin_admin($admin_user,$admin_pass)==true){
           $cid = $_POST['cid'];
           $type = $_POST['type'];
           if($type==0){
               $card_out = 1;
               $msg = "修改成功，改为已导出！";
           }else{
               $card_out = 0;
               $msg = "修改成功，改为未导出！";
           }  
           $sql = "UPDATE `qmn_card` SET `card_out`='".$card_out."' WHERE `cid`='".$cid."'";
           if($DB->query($sql)){
               $json = array("code"=>0,"msg"=>$msg);
               echo echo_json($json); 
           }else{
               $json = array("code"=>3,"msg"=>"修改失败！");
               echo echo_json($json);                
           }
        }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);             
        }
    break;    
    case 'add_card':
       if(islogin_admin($admin_user,$admin_pass)==true){
          $num = $_POST['num'];
          if($num!=''){
               add_adminlog("admin","《生成卡密》","删除了卡密《".$card_row['msg']."》！");
               for($i=0;$i<$num;$i++){
                   $key = randomkeys(24);
                   $sql="INSERT INTO `qmn_card`(`msg`,`qq`, `card_out`, `time`, `active`) VALUES ('".$key."','','0','','0')";
                    $DB->query($sql);
               }
               $json = array("code"=>1,"success"=>true,"msg"=>"成功生成了".$num."张卡密！");
               echo echo_json($json);            
          } else{
                $json = array("code"=>2,"msg"=>"请确保要生成的数量不为空！");
               echo echo_json($json);              
          }          
       }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);              
       }        
    break;
    case 'out_card':
       if(islogin_admin($admin_user,$admin_pass)==true){
          $num = $_POST['num'];
          $card_num = $DB->count("SELECT count(*) from qmn_card where active=0 and card_out=0");
          if($num!=''){
              if($num>$card_num){
                   $json = array("code"=>3,"msg"=>"没有这么多卡密可导出！");
                   echo echo_json($json);                   
              }else{
              $sql = "SELECT * FROM qmn_card where card_out=0 and active=0 order by cid DESC limit $num";
              $result = $DB->query($sql);
              $jarr = array();
              while ($rows=mysqli_fetch_array($result,MYSQL_ASSOC)){
                  $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
                  for($i=0;$i<$count;$i++){
                      unset($rows[$i]);//删除冗余数据
	 	          }
	 	          array_push($jarr,$rows['msg']);
	 	          $DB->query("UPDATE `qmn_card` SET `card_out`=1 WHERE msg='".$rows['msg']."'");
              }
               $card_num = $DB->count("SELECT count(*) from qmn_card where active=0 and card_out=0");
               $json = array(
                   "code"=>0,
                   "msg"=>"导出成功！",
                   "count"=> $num,
                   "surplus"=>$card_num,
                   "data"=>$jarr
               );
               echo echo_json($json);   
              } 
          }else{
                $json = array("code"=>2,"msg"=>"请确保要导出的数量不为空！");
               echo echo_json($json);              
          }         
       }else{
               $json = array("code"=>-1,"msg"=>"您还未登陆账号！");
               echo echo_json($json);              
       }          
    break; 
    case 'admin_log':
           $g_page = $_POST['page'];
           $limit = $_POST['limit'];
            $app_count=$DB->count("SELECT count(*) from qmn_log");
            $pagesize = $limit;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {$pages++;}
            if ($g_page=="0") {$page = 1;}
            else if (isset($g_page)) {$page = intval($g_page);} else {$page = 1;}
            $offset = $pagesize * ($page - 1);     
           $sql = "SELECT * FROM qmn_log order by id DESC limit $offset,$pagesize";
           $result = $DB->query($sql);
           $jarr = array();
           while ($rows=mysqli_fetch_array($result,MYSQL_ASSOC)){
               $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
               for($i=0;$i<$count;$i++){
                   unset($rows[$i]);//删除冗余数据
	 	       }
	 	       array_push($jarr,$rows);
	 	       
           }
            $json = array(
                "code"=>0,
                "msg"=>"获取成功！",
                "count"=> $app_count,
                "data"=>$jarr
            );
            echo echo_json($json);        
    break;
    case 'set_config'://配置站点
        $data = $_POST['data'];
        $data = json_decode($data,true);
        if(islogin_admin($admin_user,$admin_pass)!=true){
            $json = array("code"=>-1,"success"=>false,"msg"=>"修改失败,请先登录正确的管理员账号！");
            echo echo_json($json);            
        }else{
            $DB->query("UPDATE `qmn_config` SET `v`='".$data['title']."' WHERE `k`='title'");
            $DB->query("UPDATE `qmn_config` SET `v`='".$data['keywords']."' WHERE `k`='keywords'");
            $DB->query("UPDATE `qmn_config` SET `v`='".$data['description']."' WHERE `k`='description'");
            $DB->query("UPDATE `qmn_config` SET `v`='".$data['copyright']."' WHERE `k`='copyright'");
            $DB->query("UPDATE `qmn_config` SET `v`='".$data['icp']."' WHERE `k`='icp'");
            $DB->query("UPDATE `qmn_admin` SET `user`='".$data['admin_user']."' WHERE `id`='1'"); 
            if($data['admin_pass']!=""){
                $DB->query("UPDATE `qmn_admin` SET `pass`='".$data['admin_pass']."' WHERE `id`='1'");    
            }
            $json = array("code"=>1,"success"=>true,"msg"=>"修改站点信息成功！");
            echo echo_json($json);
        }        
    break;     
}
//检测管理员是否登录
function islogin_admin($user,$pass){
     global $DB;
     $admin_row = $DB->get_row("SELECT * FROM qmn_admin WHERE user='".$user."' and pass='".$pass."' limit 1");
     if($user=='' || $pass==''){
        return false;
     }else if($admin_row['user']!=$user || $admin_row['pass'] != $pass){
        return false; 
     }else{
        return true;
     }
}
//json输出
function echo_json($json){
    return json_encode($json, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
}
//管理员添加日志
function add_adminlog($user,$type,$data){
    global $DB,$date;
    $admin_row = $DB->get_row("SELECT * FROM qmn_admin WHERE user='".$user."' limit 1");
    $DB->query("INSERT INTO `qmn_log`(`user`, `type`, `data`, `ip`, `city`, `time`) VALUES ('".$user."','".$type."','".$data."','".$admin_row['ip']."','".$admin_row['city']."','".$date."')");
}
?>