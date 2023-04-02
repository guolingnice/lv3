<?php
function real_ip(){//获取IP
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
	$ip = $_SERVER['HTTP_X_REAL_IP'];
}
return $ip;
}
function get_ip_city($ip){//获取IP地址
    $unknown = 'unknown';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $url   = 'http://api.5qmn.com/api/ip.php?ip=' . $ip . '&type=text&lx=city';
    $city  = file_get_contents($url);
    return $city;

}
function send_mail($to, $sub, $msg) { //发送邮件
	global $conf;
	include_once ROOT.'includes/smtp.class.php';
	$From = $conf['mail_name'];
	$Host = $conf['mail_stmp'];
	$Port = $conf['mail_port'];
	$SMTPAuth = 1;
	$Username = $conf['mail_name'];
	$Password = $conf['mail_pwd'];
	$Nickname = $conf['sitename'];
	$SSL = false;
	$mail = new SMTP($Host , $Port , $SMTPAuth , $Username , $Password , $SSL);
	$mail->att = array();
	if($mail->send($to , $From , $sub , $msg, $Nickname)) {
		return true;
	} else {
		return $mail->log;
	}
}
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}
function getSubstr($str, $leftStr, $rightStr)
{
	$left = strpos($str, $leftStr);
	//echo '左边:'.$left;
	$right = strpos($str, $rightStr,$left);
	//echo '<br>右边:'.$right;
	if($left < 0 or $right < $left) return '';
	return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function random($length, $numeric = 0) { 
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
function randomkeys($length)   //生成随机密匙
{   
   $pattern = 'ABCDEFGHIJKLOMNOPQRSTUVWXYZ1234567890';  
    for($i=0;$i<$length;$i++)   
    {   
        $key .= $pattern{mt_rand(0,35)};    //生成php随机数   
    }   
    return $key;   
}
function isMobile(){    //判断电脑还是手机
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
    function CheckSubstrs($substrs,$text){    
        foreach($substrs as $substr)    
            if(false!==strpos($text,$substr)){    
                return true;    
            }    
            return false;    
    }  
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
              CheckSubstrs($mobile_token_list,$useragent);    
                
    if ($found_mobile){    
        return true;    
    }else{    
        return false;    
    }    
} 
function isHTTPS()//判断域名头部
{
    if (defined('HTTPS') && HTTPS) return true;
    if (!isset($_SERVER)) return FALSE;
    if (!isset($_SERVER['HTTPS'])) return FALSE;
    if ($_SERVER['HTTPS'] === 1) {  //Apache
        return TRUE;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
        return TRUE;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
        return TRUE;
    }
    return FALSE;
}
function statistics($type){//获取系统配置
    global $DB;
    if($type=="user"){
       $user = $DB->count("SELECT count(*) from qmn_user"); 
       return $user;
    }else if($type=="card"){
       $card = $DB->count("SELECT count(*) from qmn_card where active=0"); 
       return $card;
    }else if($type=="card_list"){
       $card_list = $DB->count("SELECT count(*) from qmn_card"); 
       return $card_list;        
    }else if($type=="out_card_list"){
       $out_card_list = $DB->count("SELECT count(*) from qmn_card where active=1"); 
       return $out_card_list;     
    }else if($type=="use"){
       $use = $DB->count("SELECT count(*) from qmn_user_log where active=1"); 
       return $use;        
    }
}
function config($type){//获取系统配置
    global $DB,$dbconfig;
    $row = $DB->get_row("SELECT * FROM qmn_config WHERE k='".$type."'  limit 1");
    return $row['v'];
}
function suiji_tx(){//获取随机头像
    $url = 'http://api.btstu.cn/sjtx/api.php?lx=c1&format=json';
    $data = get_curl($url);
    $json = json_decode($data,true);
    return $json['imgurl'];
}
//MD5加密
function z_md5code($str)
{
 $key = "qingmuni666";
 $td = mcrypt_module_open(MCRYPT_DES,'','ecb','');
 $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
 $ks = mcrypt_enc_get_key_size($td);
 $key = substr(md5($key), 0, $ks);
 mcrypt_generic_init($td, $key, $iv);
 $secret = mcrypt_generic($td, $str);
 mcrypt_generic_deinit($td);
 mcrypt_module_close($td);
 return $secret;
}
//MD5加密
function q_md5code($sec)
{
 $key = "qingmuni666";
 $td = mcrypt_module_open(MCRYPT_DES,'','ecb','');
 $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
 $ks = mcrypt_enc_get_key_size($td);
 $key = substr(md5($key), 0, $ks);
 mcrypt_generic_init($td, $key, $iv);
 $string = mdecrypt_generic($td, $sec);
 mcrypt_generic_deinit($td);
 mcrypt_module_close($td);
 return trim($string);
}
?>