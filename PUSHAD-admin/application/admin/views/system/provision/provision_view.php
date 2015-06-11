<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
<script language="Javascript"> 
function selfclose()
{
	if ( window.AdWebView != null )
	{
		window.AdWebView.ajsSelfPopupClose();
	}
	else
	{                               
		window.location.replace( "tad://close/popup" );
	}
}

function goTab(tabNo){
	if( tabNo == 1){
		document.getElementById("tab1").style.display = "block";
		document.getElementById("tab2").style.display = "none";

		document.getElementById("context_private").style.display = "block";
		document.getElementById("context_location").style.display = "none";
	}else{
		document.getElementById("tab1").style.display = "none";
		document.getElementById("tab2").style.display = "block";

		document.getElementById("context_private").style.display = "none";
		document.getElementById("context_location").style.display = "block";
	}
}
</script>

<style type="text/css">
body,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,legend,input,textarea,button
	{
	margin: 0;
	padding: 0;
	-webkit-text-size-adjust: none;
	list-style: none;
}

body,input,textarea,select,table,button,code {
	font-size: 13px;
	line-height: 1.3em;
	font-family: "나눔고딕", NanumGothic, "굴림", Gulim, Helvetica, AppleGothic,
		Sans-serif;
}

.it,textarea {
	border: 1px solid #bcbcbc;
}

table {
	border-collapse: collapse;
}

img,fieldset {
	border: 0;
}

a {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}

label {
	cursor: pointer;
}

em,address {
	font-style: normal;
}

/** 상단영역*/
#wraper {
	width: 100%;
}
/*		#wrap_top {width:100%; height:94px; margin-top:0; background-color:#fdfdfd;}*/
#wrap_top {
	width: 100%;
	height: 34px;
	margin-top: 0;
	background-color: #fdfdfd;
}

.logo {
	width: 100%;
	height: 53px;
	background: url(/web/images/common/full.gif) repeat-x 0 0px;
	text-align: center;
}

.logo img {
	margin-top: 13px;
}

/** tab1*/
.ht {
	position: relative;
	width: 100%;
	height: 41px;
	background: url(/web/images/common/full.gif) repeat-x 0 -56px;
	text-align: center;
	color: #fff;
}

.nv1 {
	overflow: hidden;
	width: 100%;
}

.nv1 ul {
	padding: 0px 2px 0 2px;
}

.nv1 li {
	overflow: hidden;
	float: left;
	height: 41px;
}

.nv1 .l1 {
	background: none;
}

.nv1 a,.nv1 span {
	display: block;
	height: 41px;
	color: #fff;
}

.nv1 li.on {
	background: url(/web/images/common/full.gif) repeat-x 0 -156px;
	line-height: 41px;
}

.nv1 .on a {
	background: url(/web/images/common/full.gif) no-repeat 0 -114px;
}

.nv1 .on span {
	background: url(/web/images/common/full.gif) no-repeat 100% -204px;
}

.nv1 span img {
	margin-top: 16px;
}

/** 20110706_탭영역 비율 수정**/
.nv1 .l1 {
	width: 50%;
}

.nv1 .l2 {
	width: 50%;
}

/*tab2*/
.ht {
	position: relative;
	width: 100%;
	height: 41px;
	background: url(/web/images/common/full.gif) repeat-x 0 -56px;
	text-align: center;
	color: #fff;
}

.nv2 {
	overflow: hidden;
	width: 100%;
}

.nv2 ul {
	padding: 0px 2px 0 2px;
}

.nv2 li {
	overflow: hidden;
	float: left;
	height: 41px;
}

.nv2 .l1 {
	background: none;
}

.nv2 a,.nv2 span {
	display: block;
	height: 100%;
	color: #fff;
}

.nv2 li.on {
	background: url(/web/images/common/full.gif) repeat-x 0 -156px;
	line-height: 41px;
}

.nv2 .on a {
	background: url(/web/images/common/full.gif) no-repeat 0 -114px;
}

.nv2 .on span {
	background: url(/web/images/common/full.gif) no-repeat 100% -204px;
}

.nv2 span img {
	margin-top: 16px;
}

/** 20110706_탭영역 비율 수정, 클래스네임 수정**/
.nv2 .l1_02 {
	width: 41%;
}

.nv2 .l2_02 {
	width: 59%;
}

/** // 20110706_탭영역 비율 수정**/
.nv_bottom {
	width: 100%;
	height: 10px;
	background-color: #FFF;
}

/** 본문영역*/
#center {
	margin: auto;
	width: 95%;
	overflow: auto;
	color: #5f5f5f;
	margin-top: 22px;
}

.blank {
	height: 69px;
}

/** 하단영역*/
#bottom {
	text-align: center;
	margin-bottom: 0;
	width: 100%;
	height: 69px;
	background: url(/web/images/common/full.gif) repeat-x 0 -250px;
	text-align: center;
	z-index: 100;
}

#bottom img {
	margin-top: 11px;
}

h3 {
	text-align: center;
	line-height: 1.3em;
	font-size: 14px;
}
</style>
</head>
<body>
	<div id="wraper">
		<div id="wrap_top">
			<li class="logo"><img src="/web/images/common/img_tadlogo.png" /></li>
		</div>

		<div id="center">
			<div class="rc" id="context_private" style="display: block;">
				<?php if(isset($person_offer_content)):?>
					<br />
					<p>
						<a name="1"></a>
						<div>
							<strong>&lt;SK플래닛㈜의 정보/광고 수신서비스 이용을 위한 개인정보 제공동의&gt;</strong>
						</div>
						<div style="text-align: right;">SK텔레콤㈜귀중</div>
						<div>
							<pre style="white-space:pre; word-wrap: break-word;"><?php echo $person_offer_content;?></pre>
						</div>
	
	
					</p>
				<?php endif;?>
				
				<?php if(isset($person_gather_content)):?>
					<br />
					<p>
						<a name="2"></a>
						<div>
							<strong>&lt;SK플래닛㈜의 정보/광고 수신서비스 제공을 위한 개인정보(위치정보 포함) 수집/이용 동의 &gt;</strong>
						</div>
						<div style="text-align: right;">SK플래닛(주) 귀중</div>
						<div>
							<pre style="white-space:pre; word-wrap: break-word;"><?php echo $person_gather_content;?></pre>
						</div>
	
					</p>
				<?php endif;?>
				
				<?php if(isset($location_cather_content)):?>
					<br />
					<p>
						<a name="3"></a>
						<div>
							<strong>&lt;T ad 위치기반 서비스 이용자 약관 동의&gt;&nbsp;</strong>
						</div>
						<div style="text-align: right;">SK플래닛㈜ 귀중</div>
						<div>
							<pre style="white-space:pre; word-wrap: break-word;"><?php echo $location_cather_content;?></pre>
						</div>
	
	
					</p>
				<?php endif;?>
				
				<?php if(isset($ad_receive_content)):?>
					<br />
					<p>
						<a name="4"></a>
						<div>
							<strong>&lt;정보/광고 수신 동의&gt;</strong>
						</div>
						<div style="text-align: right;">SK플래닛㈜ 귀중</div>
						<div>
							<pre style="white-space:pre; word-wrap: break-word;"><?php echo $ad_receive_content;?></pre>
						</div>
	
	
					</p>
				<?php endif;?>
				
				<?php if(isset($policy_content)):?>
					<br />
					<p>
						<a name="5"></a>
						<div>
							<strong>&lt;개인정보 취급위탁&gt;</strong>
						</div>
						<div style="text-align: right;">SK플래닛㈜ 귀중</div>
						<div><pre style="white-space:pre; word-wrap: break-word;"><?php echo $policy_content;?></pre>
						</div>
	
	
					</p>
				<?php endif;?>
			</div>
		</div>
		<div id="bottom">
			<img src="/web/images/button/btn_before.gif" alt="이전화면보기"
				onclick="selfclose()" />
		</div>
	</div>

</body>
</html>
