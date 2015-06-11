<!--컨텐츠 -->
<div id="content">
	<form id="write_form" name="write_form">
		<input type="hidden" id="campaign_sq" name="campaign_sq" value="<?php echo $campaign_vo->get_campaign_sq();?>" />
		
		<div class="subTitleArea">
			<h3>Cross-marketing 캠페인 리스트</h3>
		</div>
		<hr />
	
		<ul class="subTab01">
			<li><a href="#">캠페인 정보</a></li>
			<li class="on1"><a href="#">광고 정보</a></li>
		</ul>
	
		<h4>캠페인 정보</h4>
		<table class="boardDataType mg_t10" summary="캠페인 정보 상세 등록">
			<colgroup>
				<col width="13%" />
				<col width="37%" />
				<col width="13%" />
				<col width="37%" />
			</colgroup>
			<tbody>
				<tr>
					<th>캠페인 명</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_campaign_nm();?></td>
					<th>광고주</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_adv_company_nm();?></td>
				</tr>
				<tr>
					<th>캠페인 설명</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_campaign_desc();?></td>
					<th>브랜드</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_adv_brand_nm();?></td>
				</tr>
			</tbody>
		</table>
	
		<h4>광고 정보</h4>
		<table class="boardDataType mg_t10" summary="광고 정보 상세 등록">
			<colgroup>
				<col width="13%" />
				<col width="37%" />
				<col width="13%" />
				<col width="37%" />
			</colgroup>
			<tbody>
				<tr>
					<th>광고 명 <strong class="important">*</strong></th>
					<td class="WriteLft end" colspan="3">
						<input type="text" id="ad_nm" name="ad_nm" style="width: 80%;" />
						<span id="ad_nm_validate"><strong class="counting">0</strong> / 80자</span>
					</td>
				</tr>
				<tr>
					<th>발송 건수 <strong class="important">*</strong></th>
					<td class="WriteLft end">
						<input id="push_booking_cnt" name="push_booking_cnt" class="textType" style="width: 50%;" title="" type="text" value="" />
					</td>
					<th>발송 일자 <strong class="important">*</strong></th>
					<td class="WriteLft end">
						<input type="hidden" id="calendar_min_day" value="<?php echo $calendar_min_day;?>" />
						<input type="hidden" id="calendar_max_week" value="<?php echo $calendar_max_week;?>" />
						<input id="start_dt" name="start_dt" class="textType" style="width: 70px;" title="조회 시작일 입력" type="text" value="" />
					</td>
				</tr>
				<tr>
					<th>발송 시간 <strong class="important">*</strong></th>
					<td class="WriteLft end" colspan="3">
						<span id="time_selectbox_layer">
							<?php echo $time_selectbox;?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="btnC">
			<span><a href="javascript:advert_write();"><img src="/web/images/button/reg.gif" alt="등록" /></a> </span> 
			<span><a href="javascript:advert_cancel();"><img src="/web/images/button/cancel03.gif" alt="취소" /></a> </span>
		</div>
	</form>
</div>
<!-- //content-->
