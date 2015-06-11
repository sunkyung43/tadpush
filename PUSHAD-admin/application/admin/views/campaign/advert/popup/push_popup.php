<div id="popTop">
	<h2>
		Push Test 발송
		<a href="#" class="closePopup" onclick="window.close();" style="line-height:0px;">
			<img src="/web/images/button/close_popup.gif" alt="창 닫기" />
		</a>
	</h2>
</div>
<div class="popWrapper">
	<p>
		소재 확인을 위한 Push 광고 테스트 발송<br />
		<span class="red txtLine">※ Push 동의를 한 고객에게만 발송이 가능합니다.</span>
	</p>
	<p class="mdnArea">
		<label for="mdn">MDN<strong class="important">*</strong></label>
		<input type="hidden" id="ad_sq" name="ad_sq" value="<?php echo $ad_sq;?>" />
		<input type="text" style="width: 60%" id="mdn" name="mdn" />
	</p>
</div>
<div class="alignC">
	<a href="javascript:push();"><img src="/web/images/button/send.gif" alt="발송" /></a>
	<a href="#" onclick="window.close();"><img src="/web/images/button/cancel.gif" alt="취소" /></a>
</div>