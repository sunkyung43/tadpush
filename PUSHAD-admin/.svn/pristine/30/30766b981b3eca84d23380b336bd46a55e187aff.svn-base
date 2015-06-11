<div id="content">
	<form id="list_form" name="list_form">
		<div class="subTitleArea">
			<h3>Cross-marketing 인벤토리 현황판</h3>
		</div>

		<!-- 검색 //-->
		<div class="searchArea" style="overflow:visible">
			<strong class="title">주기</strong> : <?php echo $summary['cycle']?>일 / <strong>Frequency</strong> : <?php echo $summary['frequency_cnt']?>회
			<!-- 설명레이어팝업 -->
			<div class="infoZone">
				<a href="javascript:tooltipPopup('freequency_tooltip', true);"><img src="/web/images/button/qMark.gif" alt="설명"></a>
				<div id="freequency_tooltip" class="layerPopup_new" style="display: none;">
					<p class="text">설정 주기 범위 안 Device에 발송할 수 있는 Push 메시지 횟수</p>
					<p class="btn">
						<a href="javascript:tooltipPopup('freequency_tooltip', false);"><img src="/web/images/button/check.gif" alt="확인"></a>
					</p>
				</div>
			</div>
			<!-- //설명레이어팝업 -->
			<div class="n_search">
				<input type="hidden" id="os_ver" name="os_ver" />
				<input type="hidden" id="model_nm" name="model_nm" />
				<input type="hidden" id="media_name_cd" name="media_name_cd" />
				<input type="hidden" id="media_group_cd" name="media_group_cd" />
				<input type="hidden" id="media_category_cd" name="media_category_cd" />
				<input type="hidden" id="carrier_cd" name="carrier_cd" />
				<input type="hidden" id="gender_cd" name="gender_cd" />
				<input type="hidden" id="age_rng_cd" name="age_rng_cd" />
				<input type="hidden" id="region_sido_cd" name="region_sido_cd" />
				<input type="hidden" id="region_gugun_cd" name="region_gugun_cd" />
				
				<strong class="title">조회일</strong>
				<input type="hidden" id="calendar_max_week" value="<?php echo $calendar_max_week;?>" />
				<input id="start_dt" name="start_dt" class="textType" style="width: 70px;" title="조회 시작일 입력" type="text" value="" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:targeting();"><img id="target_off_img" src="/web/images/button/btnTargetSetting_off.gif" alt="Targeting 설정"></a>
				<a href="javascript:targeting();"><img id="target_on_img" src="/web/images/button/btnTargetSetting.gif" alt="Targeting 설정" style="display: none;"></a>
				<a href="javascript:search();"><img id="search_img" src="/web/images/button/hit_sm_btn.gif" alt="조회"></a>
				<a href="javascript:reset();"><img id="reset_off_img" src="/web/images/button/btn_settingNo_off.gif" alt="설정 초기화"></a>
				<a href="javascript:reset();"><img id="reset_on_img" src="/web/images/button/btn_settingNo.gif" alt="설정 초기화" style="display: none;"></a>
				<span id="remain_layer"></span>
			</div>
		</div>
		<!--// 검색 -->

		<p class="dotLine"></p>

		<table class="reportTable mg_b30">
			<colgroup>
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
				<col width="12.5%">
			</colgroup>
			<tbody>
				<tr>
					<td colspan="8" class="bgTitle">Frenauency 설정에 따른 현 주기 모수 현황 (<?php echo $summary['cycle_start_dt'];?> ~ <?php echo $summary['cycle_end_dt'];?>)</td>
				</tr>
				<tr class="top">
					<th>전체</th>
					<td><?php echo number_format($summary['tot_param_cnt']);?> 건</td>
					<th>발송</th>
					<td><?php echo number_format($summary['tot_request_cnt']);?> 건</td>
					<th>예약</th>
					<td><?php echo number_format($summary['tot_push_booking_cnt']);?> 건</td>
					<th>가용</th>
					<td><?php echo number_format($summary['tot_remain_cnt']);?> 건</td>
				</tr>
			</tbody>
		</table>

		<p class="floatL mg_b10">조회 시간 : <?php echo $summary['search_dt'];?></p>
		<p class="floatR textRight mg_b10"><a href="<?php echo $excel_url;?>"><img src="/web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a></p>

		<table class="reportTable txtCenter" style="clear:both">
		<colgroup>
			<col width="20%">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th>날짜</th>
				<th>대기 광고(건)</th>
				<th>예약 모수(건)</th>
				<th>가용 모수(건)</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($list as $row):?>
			<?php if($row['ad_cnt'] != '-'):?>
				<tr class="bgYellow">
					<td><?php echo $row['date'];?></td>
					<td><a href="javascript:advertListPopup('<?php echo $row['start_dt'];?>');"><?php echo $row['ad_cnt'];?></a></td>
					<td><?php echo number_format($row['push_booking_cnt']);?></td>
					<td><?php echo number_format($row['remain_cnt']);?></td>
				</tr>
			<?php else:?>
				<tr>
					<td><?php echo $row['date'];?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			<?php endif;?>
		<?php endforeach;?>
		</tbody>
		</table>

		<ul class="ulList">
			<li><span class="blt">※</span> 현재 발송 가능한 인벤토리 모수는 발송 당일의 인벤토리 모수와 차이가 있을 수 있습니다.</li>
			<li><span class="blt">※</span> 주기가 7일 및 Frequency가 2회 이상인 경우, 1일 1회 Device 발송 제약이 있습니다.(주기가 1일이면 제약 없음)</li>
			<li><span class="blt">※</span> 조회 일로부터 4주(28일) 후까지 조회 가능합니다.</li>
		</ul>
	</form>
</div>