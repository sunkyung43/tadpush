<script type="text/javascript">
    $(document).ready(function() {
    	create_dual_calendar('#searchStartDate', '#searchEndDate');
		});
	
	function make_chart(division){
		switch(division){
			case 'request':
				draw_chart(eval(<?php echo $request_cnt?>), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), '시도건수', '<?php echo $report_type?>');
				break;
			case 'success':
				draw_chart(eval(<?php echo $success_cnt?>), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), '성공건수', '<?php echo $report_type?>');
				break;
			case 'success_per':
				draw_chart(eval(<?php echo $success_per?>), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), '성공률', '<?php echo $report_type?>');
				break;
			case 'click':
				draw_chart(eval(<?php echo $tot_click?>), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), '클릭수', '<?php echo $report_type?>');
				break;
			case 'ctr':
				draw_chart(eval('<?php echo $ctr_cnt?>'), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), 'CTR', '<?php echo $report_type?>');
				break;
			default:
				draw_chart(eval(<?php echo $success_cnt?>), eval(<?php echo $campaign_nm?>), eval(<?php echo $ad_nm?>), eval(<?php echo $division_dt ?>), '성공건수', '<?php echo $report_type?>');
		}
	}
</script>
<!--컨텐츠 -->
	<div id="content">
		<div class="subTitleArea">
			<h3>Cross-marketing 미디어 리포트</h3>
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
			<th>미디어명</th>
			<td><?php echo $media_vo->get_media_nm(); ?></td>
			<th>APP ID</th>
			<td><?php echo $media_vo->get_media_key(); ?></td>
			<th>등록일</th>
			<td class="end">
				<a href="javascript:changeStartDate('<?php echo $media_vo->get_create_dt(); ?>');"><?php echo $media_vo->get_create_dt(); ?></a>
				<!-- 설명레이어팝업 -->
					<div class="infoZone">
						<a href="javascript:tooltipPopup('create_dt_tooltip', true);"><img src="/web/images/button/qMark.gif" alt="설명" /></a>
						<div id="create_dt_tooltip" class="layerPopup_new2" style="display: none;">
							<p class="text">날짜를 클릭하면 기간 조건 시작일이<br/>클릭 날짜로 선택되어 검색됩니다.</p>
							<p class="btn">
								<a href="javascript:tooltipPopup('create_dt_tooltip', false);"><img src="/web/images/button/check.gif" alt="확인" /></a>
							</p>
						</div>
					</div> <!-- //설명레이어팝업 -->
			</td>
		</tr>
		</table>
	<form id="search_form" name="search_form" action="" method="get">	
	<input type="hidden" id="media_id" name="media_id" value="<?php echo $media_vo->get_media_id();?>">
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_search">
				<strong class="title mg_l20">기간</strong>
				<input id="searchStartDate" name="searchStartDate" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $searchStartDate; ?>" /> 
				~
				<input id="searchEndDate" name="searchEndDate" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $searchEndDate; ?>"/> 
				<strong class="title mg_l20">리포트</strong>
				<?php echo $report_type_selectbox; ?>
				<a href="javascript:search();"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.gif" style="cursor: pointer;" alt="조회" /></a>
			</div>
		</div>
		<!--// 검색 -->
	</form>
		<span>* 조회일시 : <?php echo date("Y/m/d H:i")?></span>
		
		<div class="clear graphReport mg_b10" id="chart_area"></div>
		
		<table class="boardDataType02 mg_t10" summary="캠페인 리포트">
		<colgroup>
			<col width="16%">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<tr>
			<th class="first" rowspan="2">합계</th>
			<th><a href="javascript:make_chart('request')">시도 건수</a></th>
			<th><a href="javascript:make_chart('success')">성공 건수</a></th>
			<th><a href="javascript:make_chart('success_per')">성공율</a></th>
			<th><a href="javascript:make_chart('click')">Click 수</a></th>
			<th class="end"><a href="javascript:make_chart('ctr')">CTR</a></th>
		</tr>
		<tr>
			<td><?php echo number_format($total->get_tot_request_cnt());?></td>
			<td><?php echo number_format($total->get_tot_success_cnt());?></td>
			<td><?php echo $total->get_success_per();?>%</td>
			<td><?php echo number_format($total->get_tot_click());?></td>
			<td class="end"><?php echo $total->get_ctr_cnt();?>%</td>
		</tr>
		</table>
	<?php if($report_type == 'campaign'):?>
		<table class="compaingTable mg_t10" summary="미디어 리포트">
			<colgroup>
				<col width="16%">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
				<tr>
					<th class="first">캠페인</th>
					<th>광고</th>
					<th>시도 건수</th>
					<th>성공 건수</th>
					<th>성공율</th>
					<th>Click 수</th>
					<th>CTR</th>
				</tr>
				<?php if (!isset($campaign_vo) || empty($campaign_vo)): ?>
				<tr>
					<td colspan="7">검색결과가 없습니다.</td>
				</tr>
				<?php else: ?>
				<?php foreach($campaign_vo as $campaign_vo): ?>
				<tr>
					<td class=""><a href="javascript:executeAction('<?php echo $campaign_vo->get_campaign_sq();?>');"><?php echo $campaign_vo->get_campaign_nm();?></a></td>
					<td class=""><a href="javascript:executeMediaAction('<?php echo $campaign_vo->get_campaign_sq();?>', '<?php echo $campaign_vo->get_ad_sq();?>');"><?php echo $campaign_vo->get_ad_nm();?></a></td>
					<td class=""><?php echo number_format($campaign_vo->get_request_cnt());?></td>
					<td class=""><?php echo number_format($campaign_vo->get_success_cnt());?></td>
					<td class=""><?php echo $campaign_vo->get_success_per();?>%</td>
					<td class=""><?php echo number_format($campaign_vo->get_tot_click());?></td>
					<td class=""><?php echo $campaign_vo->get_ctr_cnt();?>%</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
		<p class="mg_t10" style="text-align:right">
			<a href="/report/pcpMediaReport/detail_excel?media_id=<?php echo $media_vo->get_media_id();?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&report_type=campaign">
			<img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/>
			</a>
		</p>
		<div class="pagingList">
			<?php echo isset($paging) ? $paging : ''; ?>
		</div>
		<?php elseif($report_type == 'month'):?>
		<!-- 월별 리포트 -->
		<table class="compaingTable mg_t10" summary="월별 리포트">
			<colgroup>
				<col width="16%">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
			<tr>
				<th class="first">월</th>
				<th>시도 건수</th>
				<th>성공 건수</th>
				<th>성공율</th>
				<th>Click 수</th>
				<th>CTR</th>
			</tr>
			<?php if (!isset($campaign_vo) || empty($campaign_vo)): ?>
			<tr>
				<td colspan="6">검색결과가 없습니다.</td>
			</tr>
			<?php else: ?>
			<?php foreach($campaign_vo as $campaign_vo): ?>
			<tr>
				<td><a href="/report/pcpMediaReport/detail?media_id=<?php echo $campaign_vo->get_media_id();?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&report_type=daily"><?php echo $campaign_vo->get_division_dt();?></a></td>
				<td class=""><?php echo number_format($campaign_vo->get_request_cnt());?></td>
				<td class=""><?php echo number_format($campaign_vo->get_success_cnt());?></td>
				<td class=""><?php echo $campaign_vo->get_success_per();?>%</td>
				<td class=""><?php echo number_format($campaign_vo->get_tot_click());?></td>
				<td class=""><?php echo $campaign_vo->get_ctr_cnt();?>%</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
		</table>
		<p class="mg_t10" style="text-align:right"><a href="detail_excel?media_id=<?php echo $media_vo->get_media_id();?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&report_type=month"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
		<!-- 월별 리포트 -->
		<?php else:?>
		<!-- 일별 리포트 -->
		<table class="compaingTable mg_t10" summary="일별 리포트">
			<colgroup>
				<col width="16%">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
			<tr>
				<th class="first">일</th>
				<th>시도 건수</th>
				<th>성공 건수</th>
				<th>성공율</th>
				<th>Click 수</th>
				<th>CTR</th>
			</tr>
			<?php if (!isset($campaign_vo) || empty($campaign_vo)): ?>
			<tr>
				<td colspan="6">검색결과가 없습니다.</td>
			</tr>
			<?php else: ?>
			<?php foreach($campaign_vo as $campaign_vo): ?>
			<tr>
				<td><?php echo $campaign_vo->get_division_dt();?></td>
				<td class=""><?php echo number_format($campaign_vo->get_request_cnt());?></td>
				<td class=""><?php echo number_format($campaign_vo->get_success_cnt());?></td>
				<td class=""><?php echo $campaign_vo->get_success_per();?>%</td>
				<td class=""><?php echo number_format($campaign_vo->get_tot_click());?></td>
				<td class=""><?php echo $campaign_vo->get_ctr_cnt();?>%</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
		</table>
		<p class="mg_t10" style="text-align:right"><a href="/report/pcpMediaReport/detail_excel?media_id=<?php echo $media_vo->get_media_id();?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&report_type=daily"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
		<!-- 일별 리포트 -->
		<?php endif;?>
		<div class="btnListArea">
			<p class="btnC">
				<a href="/report/pcpMediaReport"><img  src="../../web/images/button/btn_list.gif" alt="목록" /></a>
			</p>
		</div>

	</div>
	<!-- //content-->
