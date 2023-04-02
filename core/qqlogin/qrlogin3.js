var interval1,interval2;
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();
function setCookie(name,value)
{
	var exp = new Date();
	exp.setTime(exp.getTime() + 30*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null){
      document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }
}
function getqrpic(force){
	force = force || false;
	cleartime();
	var qrsig = getCookie('qrsig');
	var qrimg = getCookie('qrimg');
	if(qrsig!=null && qrimg!=null && force==false){
		$('#qrimg').attr('qrsig',qrsig);
		$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+qrimg+'" title="点击刷新">');
		if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
			$('#mobile').show();
		}
		interval1=setInterval(loginload,1000);
		interval2=setInterval(qrlogin,3000);
	}else{
		var getvcurl=siteurl+'qq/getsid/login.php?do=getqrpic3rd&daid='+daid+'&appid='+appid+'&r='+Math.random(1);
		$.get(getvcurl, function(d) {
			if(d.saveOK ==0){
				setCookie('qrsig',d.qrsig);
				setCookie('qrimg',d.data);
				$('#qrimg').attr('qrsig',d.qrsig);
				$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+d.data+'" title="点击刷新">');
				if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
					$('#mobile').show();
				}
				interval1=setInterval(loginload,1000);
				interval2=setInterval(qrlogin,3000);
			}else{
				alert(d.msg);
			}
		}, 'json');
	}
}
function qrlogin(){
	if ($('#login').attr("data-lock") === "true") return;
	var qrsig=$('#qrimg').attr('qrsig');
	var url = siteurl+'qq/getsid/login.php?do=qrlogin3rd&daid='+daid+'&appid='+appid+'&qrsig='+decodeURIComponent(qrsig)+'&r='+Math.random(1);
	$.get(url, function(d) {
		if(d.saveOK ==0){
			$('#loginmsg').html('已经成功'+sitename);
			$('#login').hide();
			$('#qrimg').html('<div class="alert alert-success"><img src="images/ok.gif">已经成功登录'+sitename+'</div>');
			$('#submit').hide();
			$('#login').attr("data-lock", "true");
			cleartime();
			ajax.post("ajax.php?mod=addqq&act=setCookie&r="+Math.random(1), {qq:d.uin, app:app, cookie:d.cookie}, 'json', function(arr) {
				if(arr.code==1) {
					if($_GET['return']){
						$('#qrimg').append('1秒后自动跳转...');
						setTimeout("window.location.replace('"+decodeURIComponent($_GET['return'])+"')",1000);
					}
				}else{
					alert(arr.msg);
				}
			});
		}else if(d.saveOK ==1){
			getqrpic(true);
			$('#loginmsg').html('请重新扫描二维码');
		}else if(d.saveOK ==2){
			$('#loginmsg').html('使用QQ手机版扫描二维码');
		}else if(d.saveOK ==3){
			$('#loginmsg').html('扫描成功，请在手机上确认授权登录');
		}else{
			cleartime();
			$('#loginmsg').html(d.msg);
		}
	}, 'json');
}
function loginload(){
	if ($('#login').attr("data-lock") === "true") return;
	var load=document.getElementById('loginload').innerHTML;
	var len=load.length;
	if(len>2){
		load='.';
	}else{
		load+='.';
	}
	document.getElementById('loginload').innerHTML=load;
}
function cleartime(){
	clearInterval(interval1);
	clearInterval(interval2);
	delCookie('qrsig');
	delCookie('qrimg');
}
function mloginurl(){
	var imagew = $('#qrcodeimg').attr('src');
	imagew = imagew.replace(/data:image\/png;base64,/, "");
	$('#mlogin').html("正在跳转...");
	ajax.post("index.php?mod=qrcode&r="+Math.random(1),{image:imagew}, 'json', function(arr) {
		if(arr.code==0) {
			$('#loginmsg').html('跳转到QQ登录后请返回此页面');
			window.location.href='mqqapi://forward/url?version=1&src_type=web&url_prefix='+window.btoa(arr.url);
		}else{
			alert(arr.msg);
		}
		$('#mlogin').html("跳转QQ快捷登录");
	});
}
$(document).ready(function(){
	getqrpic();
});