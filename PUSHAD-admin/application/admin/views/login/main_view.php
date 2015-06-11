<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<title>adot Push</title>
<link rel="shortcut icon" href="/web/icon/favicon.ico" type="image/ico" />
<link rel="stylesheet" type="text/css" href="/web/css/common_v2.css" />
<link rel="stylesheet" type="text/css" href="/web/css/layout_v2.css" />
<link rel="stylesheet" type="text/css" href="/web/css/board_v2.css" />
<link rel="stylesheet" type="text/css" href="/web/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" type="text/css" href="/web/css/popup_ext.css" />
<link rel="stylesheet" type="text/css" href="/web/css/validation.css" />

<script type="text/javascript" src="/web/js/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/web/js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="/web/js/jquery/additional-methods.min.js"></script>
<script type="text/javascript" src="/web/js/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/web/js/jquery/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="/web/js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/web/js/common/common.js"></script>
<script type="text/javascript" src="/web/js/common/expression.js"></script>
<script type="text/javascript" src="/web/js/ext/common_cal.js"></script>
<script type="text/javascript" src="/web/js/ext/common_ext.js"></script>
<script type="text/javascript" src="/web/js/ext/common_layer.js"></script>
<script type="text/javascript" src="/web/js/ext/common_menu.js"></script>
<script type="text/javascript" src="/web/js/ext/common_validation.js"></script>
<script type="text/javascript" src="/web/js/jquery/jquery.jcryption-1.0.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#user_id").focus();


	$("#user_pw").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#submitButton").click();
		}
	});

	//$.ajaxSetup({timeout:5000});
	$("#loginFrm").jCryption({
		submitTrigger		:	"#submitButton",
		getKeysURL			:	"/login/main/login?generateKeypair=true",
		ajaxSubmit			:	true,
		disableAllFields	:	false,
		ajaxDataType		:	"json",
		beforeEncryption	:	function() {
			return true;
			},
		ajaxSubmitSuccess	:	function(json, textStatus){
				if (json.response_type == 'success') {
					var path_name = location.pathname;
					var referrer_name = document.referrer.split("/").slice(
							3).join('/');
					if (referrer_name != '' && referrer_name != '/'
							&& referrer_name != '/index.php'
							&& referrer_name.indexOf('login/main') < 0) {
						location.replace(referrer_name);
						return;
					}
					if (path_name == '' || path_name == '/'
							|| path_name == '/index.php'
							|| path_name.indexOf('login/main') >= 0) {
						var replaceUrl = json.response_data.MENU_URL ? json.response_data.MENU_URL : '/campaign/campaign';
						location.replace(replaceUrl);
						return;
					}
	
					else
						var replaceUrl = json.response_data.MENU_URL ? json.response_data.MENU_URL : '/campaign/campaign';
						location.replace(replaceUrl);
					return;
				} else if (json.response_type == 'deny_ip') {
					// alert("등록된 아이피가 아닙니다.");
					new_window('/popup/ip', 'deny_ip', '', '500', '350');
				} else if (json.response_type == 'login_used') {
					if (confirm('기존 접속정보가 있습니다.\n기존 접속을 끊고 다시 접속하시겠습니까?')) {
						$("#login_force").val(1);
						login();
					}
					return;
				} else if (json.response_type == 'fail') {
					alert("아이디 혹은 비밀번호가 일치하지 않습니다.");
				} else {
					alert(json.response_data);
				}
			},
		ajaxSubmitError:function(XMLHttpRequest, textStatus, errorThrown){
				alert('처리 도중 오류가 발생하였습니다.');
				return;
			}
	});

});

</script>
</head>

<body id="Login">
	<div id="Wrapper">
		<div id="mask" class="popupMask"></div>
		<div id="loading_bg" class="loadingBg"></div>
		<div id="loading" class="loadingWindow">
			<img id="loading_img" src="/web/images/common/ajax-loader.gif" />
		</div>

		<div id="LoginBody">
			<h1 class="invisible">imAD - Ad Network Platform Center</h1>
			<form id="loginFrm" name="loginFrm" action="/login/main/login"
				method="post">
				<div class="loginBox">
					<fieldset>
						<legend>로그인</legend>
						<p class="inputLine">
							<label for="UserID"><img src="/web/images/common/txt_user_id.gif"
								alt="User ID" /> </label> <input id="user_id" type="text"
								name="user_id" class="textType" value="" title="아이디 입력"
								maxlength="16" style="ime-mode: disabled;" />
						</p>
						<p class="inputLine">
							<label for="PW"><img src="/web/images/common/txt_user_pw.gif"
								alt="Password" /> </label> <input id="user_pw" name="user_pw"
								type="password" class="textType" value="" maxlength="16"
								title="비밀번호 입력" />
						</p>
						<span class="btnLogin"> <a id="submitButton" href="#"><img
								src="/web/images/button/login.gif" alt="LOGIN" /> </a>
						</span>
					</fieldset>
				</div>
			</form>
		</div>

		<!-- footer -->
		<div id="Footer">
			<div class="footerLogo textCenter">
				<a href="http://www.in-cross.co.kr" target="_blank"><img
					src="/web/images/common/footer_logo.gif" alt="incross" /> </a>
			</div>
			<p class="copyright textCenter">
				<img src="/web/images/common/copyright.gif"
					alt="Copyright &copy; 2010 incross Co.,Ltd. All Rights Reserved" />
			</p>
			<address class=" textCenter">
				<img src="/web/images/common/address.gif"
					alt="서울시 강남구 역삼동 707-34 한신인터밸리24 서관 18층      대표자 : 이재원, 김순종   |    사업자등록번호 : 214-88-13475" />
			</address>
		</div>
		<!-- //footer -->
	</div>
</body>
</html>
