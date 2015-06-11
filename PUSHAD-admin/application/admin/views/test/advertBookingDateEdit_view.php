<!--컨텐츠 -->
<div id="content">
	<form id="edit_form" name="edit_form">

		<input type="hidden" id="campaign_sq" name="campaign_sq" value="<?php echo $campaign_sq; ?>" />
		<input type="hidden" id="ad_sq" name="ad_sq" value="<?php echo $ad_sq; ?>" />
		<input type="hidden" id="start_dt" name="start_dt" value="<?php echo $start_dt;?>" />

		<div class="subTitleArea">
			<h3>테스트용 발송시간 변경</h3>
		</div>

		<table class="boardDataType" summary="테스트용 발송시간 변경">
			<colgroup>
				<col width="10%" />
				<col width="90%" />
			</colgroup>
			<tr>
				<th>캠페인명</th>
				<td><?php echo $campaign_nm; ?></td>
			</tr>
			<tr>
				<th>AD명</th>
				<td><?php echo $ad_nm; ?></td>
			</tr>
			<tr>
				<th colspan="2">발송시간</th>
			</tr>
			<tr>
				<th>년</th>
				<td><input type="text" id="year" name="year" maxlength="4"
					value="<?php echo $year;?>" /></td>
			</tr>
			<tr>
				<th>월</th>
				<td><input type="text" id="month" name="month" maxlength="2"
					value="<?php echo $month;?>" /></td>
			</tr>
			<tr>
				<th>일</th>
				<td><input type="text" id="day" name="day" maxlength="2"
					value="<?php echo $day;?>" />
				</td>
			</tr>
			<tr>
				<th>시</th>
				<td><input type="text" id="hour" name="hour" maxlength="2"
					value="<?php echo $hour;?>" /></td>
			</tr>
			<tr>
				<th>분</th>
				<td><input type="text" id="minute" name="minute" maxlength="2"
					value="<?php echo $minute;?>" /></td>
			</tr>
		</table>

		<div class="btnC clear">
			<a
				href="javascript:request('edit_form', 'POST', '/test/test/advertBookingDateEdit');">
				<img src="/web/images/button/btn_modify.gif" alt="수정" />
			</a> <a
				href="/campaign/campaign/detail?campaign_sq=<?php echo $campaign_sq; ?>">
				<img src="/web/images/button/cancel03.gif" alt="취소" />
			</a>
		</div>

	</form>
</div>
<!-- //content-->
