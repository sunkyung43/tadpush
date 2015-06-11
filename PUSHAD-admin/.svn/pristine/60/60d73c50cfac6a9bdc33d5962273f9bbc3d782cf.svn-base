<!--컨텐츠 -->
<div id="content">
	<form id="write_form" name="write_form">
		<div class="subTitleArea">
			<h3>Frequency 관리</h3>
		</div>
	
		<table class="boardDataType" summary="Frequency 관리">
			<colgroup>
				<col width="20%" />
				<col width="30%" />
				<col width="20%" />
				<col width="30%" />
			</colgroup>
			<tr>
				<th>현재 기간</th>
				<td><?php echo $frequency['cycle'];?>일</td>
				<th>Frequency</th>
				<td class="end"><?php echo $frequency['frequency_cnt'];?>회</td>
			</tr>
		</table>
	
		<table class="boardDataType mg_t20" summary="Frequency 관리">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<tr>
				<th>주기설정 <strong class="important">*</strong></th>
				<td class="end">
					<select id="cycle" name="cycle" onchange="javascript:AddFrequencySelectbox();">
						<option value="1">1</option>
						<option value="7">7</option>
					</select>
					 일
				</td>
			</tr>
			<tr>
				<th>Frequency 설정 <strong class="important">*</strong></th>
				<td class="end">
					<!-- 
					<select id="frequency_cnt" name="frequency_cnt">
					</select>
					  -->
					<input id="frequency_cnt" name="frequency_cnt" class="textType" title="" type="text" value="" />
					 회
				</td>
			</tr>
			<tr>
				<th>적용일자 <strong class="important">*</strong></th>
				<td class="end">
					<input type="hidden" id="calendar_min_day" name="calendar_min_day" value="<?php echo $calendar_min_day;?>" />
					<input id="start_dt" name="start_dt" class="textType" style="width: 70px;" title="조회 종료일 입력" type="text" value="" />
				</td>
			</tr>
		</table>
	
		<ul class="ulList">
			<li>
				<span class="blt">※</span>
				설정된 Frequency 값은 적용 일자 의 00:00 기준으로 변경됩니다.
			</li>
			<li>
				<span class="blt">※</span> 
				예약된 AD의 발송 날짜 이후 및 Frequency 주기가 끝나는 시점으로 적용 가능합니다.
			</li>
		</ul>
	
		<div class="btnC clear">
			<a href="javascript:push_setting_write();">
				<img src="/web/images/button/reg.gif" alt="등록" />
			</a>
			<a href="javascript:push_setting_cancel();">
				<img src="/web/images/button/cancel03.gif" alt="취소" />
			</a>
		</div>
	</form>
</div>
<!-- //content-->
