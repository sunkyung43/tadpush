<script type="text/javascript">
	function calendar(){
		create_dual_calendar('#searchStartDate', '#searchEndDate');
	}
	
	function make_chart(division){
		switch(division){
			case 'request':
				draw_chart(eval(<?php echo $request_cnt?>), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm?>), eval(<?php echo $division_dt ?>), '시도건수', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
				break;
			case 'success':
				draw_chart(eval(<?php echo $success_cnt?>), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm ?>), eval(<?php echo $division_dt ?>), '성공건수', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
				break;
			case 'success_per':
				draw_chart(eval(<?php echo $success_per?>), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm ?>), eval(<?php echo $division_dt ?>), '성공률', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
				break;
			case 'click':
				draw_chart(eval(<?php echo $tot_click?>), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm ?>), eval(<?php echo $division_dt ?>), '클릭수', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
				break;
			case 'ctr':
				draw_chart(eval('<?php echo $ctr_cnt?>'), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm ?>), eval(<?php echo $division_dt ?>), 'CTR', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
				break;
			default:
				draw_chart(eval(<?php echo $success_cnt?>), eval(<?php echo $ad_nm?>), eval(<?php echo $media_nm ?>), eval(<?php echo $division_dt ?>), '성공건수', '<?php echo $report_type?>', '<?php echo $ad_report_type?>', '<?php echo $ad_sq?>');
		}
	}
</script>
<!--컨텐츠 -->
	<div id="content">
		<div class="subTitleArea">
			<h3>캠페인 리포트</h3>
		</div>
		<table class="boardDataType" summary="캠페인 리포트 상세보기">
		<colgroup>
			<col width="13%" />
			<col width="20%" />
			<col width="13%" />
			<col width="20%" />
			<col width="13%" />
			<col width="21%" />
		</colgroup>
		<tr>
			<th>캠페인명</th>
			<td><?php echo $campaign_vo->get_campaign_nm(); ?></td>
			<th>캠페인 기간</th>
			<td><?php echo $campaign_vo->get_start_dt() ?> ~ <?php echo $campaign_vo->get_end_dt() ?></td>
			<th>광고주 명</th>
			<td class="end"><?php echo $campaign_vo->get_adv_company_nm(); ?></td>
		</tr>
		<tr>
			<th>목표건수</th>
			<td><?php echo number_format($campaign_vo->get_tot_push_booking_cnt()) ?> 건</td>
			<th>발송건수</th>
			<td><?php echo number_format($campaign_vo->get_request_cnt()) ?> 건</td>
			<th>브랜드 명</th>
			<td class="end"><?php echo $campaign_vo->get_adv_brand_nm() ?></td>
		</tr>
		</table>
	<form name="search_form" action="" method="get">
	<input type="hidden" id="campaign_sq" name="campaign_sq" value="<?php echo $campaign_vo->get_campaign_sq();?>"/>
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_search">
				<strong class="title mg_l20">기간</strong>
				<input id="searchStartDate" name="searchStartDate" class="textType" style="width: 70px;" title="조회 시작일 입력" type="text" value="<?php echo $searchStartDate;?>" /> ~ 
				<input id="searchEndDate" name="searchEndDate" class="textType" style="width: 70px;" title="조회 종료일 입력" type="text" value="<?php echo $searchEndDate;?>" /> 
				<strong class="title mg_l20">광고</strong>
					<?php echo $ad_name_selectbox;?>
				<strong class="title mg_l20">리포트</strong>
					<?php echo $report_type_selectbox;?>
					<?php echo $ad_report_type_selectbox;?>
				<img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.gif" onClick="javascript: search_form.submit()" style="cursor: pointer;" alt="조회" />
			</div>
		</div>
		<!--// 검색 -->
	</form>
		<p>※조회 일시 : <?php echo date("Y/m/d H:i")?></p>
		<div id="graphReport">
			<div class="clear graphReport mg_b10" id="chart_area"></div>
		
			<table class="boardDataType02" summary="요약 리포트">
			<colgroup>
				<col width="10%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
			</colgroup>
			<tr>
				<th rowspan="2">합계</th>
				<th><a href="javascript:make_chart('request')">시도 건수</a></th>
				<th><a href="javascript:make_chart('success')">성공 건수</a></th>
				<th><a href="javascript:make_chart('success_per')">성공률</a></th>
				<th><a href="javascript:make_chart('click')">Click 수</a></th>
				<th class="end"><a href="javascript:make_chart('ctr')">CTR</a></th>
			</tr>
			<tr>
				<td><?php echo $total->get_tot_request_cnt(); ?></td>
				<td><?php echo $total->get_tot_success_cnt(); ?></td>
				<td><?php echo $total->get_success_per(); ?>%</td>
				<td><?php echo $total->get_tot_click(); ?></td>
				<td class="end"><?php echo $total->get_ctr_cnt(); ?>%</td>
			</tr>
			</table>
		</div>
			<?php if($ad_sq == ''): ?>
				<?php if($report_type == 'summery'):?>
					<!-- 요약일 때 -->
					<table class="compaingTable mg_t10" summary="요약 리포트">
					<colgroup>
						<col width="23%">
						<col width="15%">
						<col width="11%">
						<col width="11%">
						<col width="11%">
						<col width="11%">
						<col width="11%">
					</colgroup>
					<thead>
						<tr>
							<th class="first">광고명</th>
							<th>발송 일시</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!isset($ad_vo) || empty($ad_vo)): ?>
						<tr>
							<td colspan="7">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($ad_vo as $ad_vo): ?>
					<tr>
						<td><a href="/report/pcpCampaignReport/detail?campaign_sq=<?php echo $campaign_vo->get_campaign_sq();?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&report_type=media&ad_report_type=media&ad_name=<?php echo $ad_vo->get_ad_nm();?>&ad_sq=<?php echo $ad_vo->get_ad_sq();?>&type=<?php echo $type;?>"><?php echo $ad_vo->get_ad_nm(); ?></a></td>
						<td><?php echo $ad_vo->get_division_dt(); ?></td>
						<td><?php echo number_format($ad_vo->get_request_cnt()) ?></td>
						<td><?php echo number_format($ad_vo->get_success_cnt()) ?></td>
						<td><?php echo $ad_vo->get_success_per(); ?>%</td>
						<td><?php echo number_format($ad_vo->get_tot_click()) ?></td>
						<td class="end"><?php echo $ad_vo->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 요약일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php elseif($report_type == 'media'):?>
					<!-- 미디어일 때 -->
					<table class="compaingTable mg_t10" summary="미디어 리포트">
					<colgroup>
						<col width="24%">
						<col width="16%">
						<col width="12%">
						<col width="12%">
						<col width="11%">
						<col width="13%">
					</colgroup>
					<thead>
						<tr>
							<th class="first">미디어</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!isset($media_vo) || empty($media_vo)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($media_vo as $media_vo): ?>
					<tr>
						<td><a href="javascript:executeAction('<?php echo $media_vo->get_media_id();?>');"><?php echo $media_vo->get_media_nm(); ?></a></td>
						<td><?php echo number_format($media_vo->get_request_cnt()) ?></td>
						<td><?php echo number_format($media_vo->get_success_cnt()) ?></td>
						<td><?php echo $media_vo->get_success_per(); ?>%</td>
						<td><?php echo number_format($media_vo->get_tot_click()) ?></td>
						<td class="end"><?php echo $media_vo->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 미디어일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php elseif($report_type == 'month'):?>
					<!-- 월별일 때 -->
					<table class="compaingTable mg_t10" summary="월별 리포트">
					<colgroup>
						<col width="10%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
					</colgroup>
					<thead>
						<tr>
							<th class="first">월</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!isset($ad_vo) || empty($ad_vo)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($ad_vo as $ad_vo): ?>
					<tr>
						<td><a href="/report/pcpCampaignReport/detail?campaign_sq=<?php echo $campaign_vo->get_campaign_sq();?>&searchStartDate=<?php echo $ad_vo->get_division_dt(); ?>&searchEndDate=&report_type=daily&report=daily"><?php echo $ad_vo->get_division_dt(); ?></a></td>
						<td><?php echo number_format($ad_vo->get_request_cnt()); ?></td>
						<td><?php echo number_format($ad_vo->get_success_cnt()); ?></td>
						<td><?php echo $ad_vo->get_success_per(); ?>%</td>
						<td><?php echo number_format($ad_vo->get_tot_click()); ?></td>
						<td class="end"><?php echo $ad_vo->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 월별일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php elseif($report_type == 'daily'):?>
					<!-- 일별일 때 -->
					<table class="compaingTable mg_t10" summary="일별 리포트">
					<colgroup>
						<col width="10%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
						<col width="15%" />
					</colgroup>
					<thead>
						<tr>
							<th class="first">일</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!isset($ad_vo) || empty($ad_vo)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($ad_vo as $ad_vo): ?>
					<tr>
						<td><?php echo $ad_vo->get_division_dt(); ?></td>
						<td><?php echo number_format($ad_vo->get_request_cnt()); ?></td>
						<td><?php echo number_format($ad_vo->get_success_cnt()); ?></td>
						<td><?php echo $ad_vo->get_success_per(); ?>%</td>
						<td><?php echo number_format($ad_vo->get_tot_click()); ?></td>
						<td class="end"><?php echo $ad_vo->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 일별일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php endif;?>
			<?php elseif($ad_sq != ''):?>	
				<?php if($ad_report_type == 'target'):?>
					<!-- 기본타게팅일 때 -->
					<table class="compaingTable mg_t10" summary="기본 타게팅 리포트">
					<colgroup>
						<col width="25%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
					</colgroup>
					<thead>
						<tr>
							<th class="first">기본 타게팅</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody id="target">
					<?php if (!isset($target) || empty($target)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($target as $target): ?>
					<?php if($target->get_target() == '1'):?>
					<tr style="background:beige; font-weight:bold;">
						<td><?php echo $target->get_target_nm(); ?></td>
						<td><?php echo number_format($target->get_request_cnt()); ?></td>
						<td><?php echo number_format($target->get_success_cnt()); ?></td>
						<td><?php echo $target->get_success_per(); ?>%</td>
						<td><?php echo number_format($target->get_tot_click()); ?></td>
						<td class="end"><?php echo $target->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php else:?>
					<tr>
						<td><?php echo $target->get_target_nm(); ?></td>
						<td><?php echo number_format($target->get_request_cnt()); ?></td>
						<td><?php echo number_format($target->get_success_cnt()); ?></td>
						<td><?php echo $target->get_success_per(); ?>%</td>
						<td><?php echo number_format($target->get_tot_click()); ?></td>
						<td class="end"><?php echo $target->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endif;?>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 기본타게팅일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php elseif($ad_report_type == 'isf'):?>
					<!-- isf 타게팅일 때 -->
					<table class="compaingTable mg_t10" summary="isf 타게팅 리포트">
					<colgroup>
						<col width="25%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
					</colgroup>
					<thead>
						<tr>
							<th class="first">ISF 타게팅</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody id="isf">
					<?php if (!isset($isf) || empty($isf)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($isf as $isf): ?>
					<?php if($isf->get_target() == '1'):?>
					<tr style="background:beige; font-weight:bold;">
						<td><?php echo $isf->get_target_nm(); ?></td>
						<td><?php echo number_format($isf->get_request_cnt()); ?></td>
						<td><?php echo number_format($isf->get_success_cnt()); ?></td>
						<td><?php echo $isf->get_success_per(); ?>%</td>
						<td><?php echo number_format($isf->get_tot_click()); ?></td>
						<td class="end"><?php echo $isf->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php else:?>
					<tr>
						<td><?php echo $isf->get_target_nm(); ?></td>
						<td><?php echo number_format($isf->get_request_cnt()); ?></td>
						<td><?php echo number_format($isf->get_success_cnt()); ?></td>
						<td><?php echo $isf->get_success_per(); ?>%</td>
						<td><?php echo number_format($isf->get_tot_click()); ?></td>
						<td class="end"><?php echo $isf->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endif;?>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- isf 타게팅일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php elseif ($ad_report_type == 'media'):?>
					<!-- 미디어일 때 -->
					<table class="compaingTable mg_t10" summary="미디어 리포트">
					<colgroup>
						<col width="24%">
						<col width="16%">
						<col width="12%">
						<col width="12%">
						<col width="11%">
						<col width="13%">
					</colgroup>
					<thead>
						<tr>
							<th class="first">미디어</th>
							<th>시도 건수</th>
							<th>성공 건수</th>
							<th>성공률</th>
							<th>Click 수</th>
							<th class="end">CTR</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!isset($media_vo) || empty($media_vo)): ?>
						<tr>
							<td colspan="6">검색결과가 없습니다.</td>
						</tr>
					<?php else: ?>
					<?php foreach($media_vo as $media_vo): ?>
					<tr>
						<td><a href="javascript:executeAction('<?php echo $media_vo->get_media_id();?>');"><?php echo $media_vo->get_media_nm(); ?></a></td>
						<td><?php echo number_format($media_vo->get_request_cnt()) ?></td>
						<td><?php echo number_format($media_vo->get_success_cnt()) ?></td>
						<td><?php echo $media_vo->get_success_per(); ?>%</td>
						<td><?php echo number_format($media_vo->get_tot_click()) ?></td>
						<td class="end"><?php echo $media_vo->get_ctr_cnt(); ?>%</td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
					</tbody>
					</table>
					<!-- 미디어일 때 -->
					<p class="mg_t10" style="text-align:right"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
				<?php endif;?>
			<?php endif;?>
		<div class="btnListArea">
			<p class="btnC">
				<a href="/report/pcpCampaignReport"><img  src="../../web/images/button/btn_list.gif" alt="목록" /></a>
			</p>
		</div>
	</div>
	<!-- //content-->