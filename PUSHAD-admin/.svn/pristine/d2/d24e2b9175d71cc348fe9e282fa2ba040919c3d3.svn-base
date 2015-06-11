<script type="text/javascript">
<!--
    $(document).ready(function() {
    	create_dual_calendar('#searchStartDate', '#searchEndDate');
		});
//-->
</script>
<!--컨텐츠 -->
<div id="content">
	<form id="list_form" name="list_form">
	<div class="subTitleArea">
		<h3>캠페인 리스트</h3>
	</div>
	<!-- 검색 //-->
	<div class="searchArea">
		<div class="n_class">
			<strong class="title">상태</strong> 
			<?php echo $status_type_selectbox;?>
			<strong class="title mg_l20">기간</strong> 
			<input id="searchStartDate" name="searchStartDate" class="textType" style="width: 70px;" title="조회 시작일 입력" type="text" value="<?php echo $searchStartDate;?>" /> ~ 
			<input id="searchEndDate" name="searchEndDate" class="textType" style="width: 70px;" title="조회 종료일 입력" type="text" value="<?php echo $searchEndDate;?>" /> 
		</div>
		<div class="n_search">
			<strong class="title">검색조건</strong> 
			<?php echo $search_type_selectbox;?>
			<input type="text" id="searchValue" name="searchValue" class="textType" title="검색어 입력" value="<?php echo $search_value;?>" /> 
					<a href="javascript:search();"><img id="BTN_SEARCH" src="../../web/images/button/search.gif" style="cursor: pointer;" alt="검색" /></a>
		</div>
	</div>
	<!--// 검색 -->
	<p class="dotLine"></p>

	<div class="searchArea02">
		<div class="n_class">
		<?php echo $paging_volume;?>
		</div>
		<p class="textRight">
			<span class="dataResult">총 <strong><?php echo $total_rows;?></strong> 건의 데이터가 검색되었습니다.</span> 
			<a href="/report/pcpCampaignReport/list_excel?status_type=<?php echo $status_type;?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&search_type=<?php echo $search_type;?>&search_value=<?php echo $search_value;?>">
				<img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드" /> 
			</a>
		</p>
	</div>

	<table class="compaingTable" summary="캠페인 리스트">
		<colgroup>
			<col width="5%">
			<col width="14%">
			<col width="9%">
			<col width="9%">
			<col width="12%">
			<col width="12%">
			<col width="12%">
		</colgroup>
		<thead>
			<tr class="2block">
				<th rowspan="2" class="first">No</th>
				<th rowspan="2">캠페인 명</th>
				<th rowspan="2">광고주</th>
				<th rowspan="2">브랜드</th>
				<th rowspan="2">기간</th>
				<th rowspan="2">목표건수</th>
				<th rowspan="2">발송건수</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="7">검색결과가 없습니다.</td>
			</tr>
		<?php else: ?>
			<?php foreach($list as $report_vo): ?>
			<tr>
				<td><?php echo $report_vo->get_row_num() ?></td>
				<td><a href="/report/pcpCampaignReport/detail?campaign_sq=<?php echo $report_vo->get_campaign_sq(); ?>&report_type=summery&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>"><?php echo $report_vo->get_campaign_nm() ?></a></td>
				<td><?php echo $report_vo->get_adv_company_nm() ?></td>
				<td><?php echo $report_vo->get_adv_brand_nm() ?></td>
				<td><?php echo $report_vo->get_start_dt() ?> ~ <?php echo $report_vo->get_end_dt() ?></td>
				<td><?php echo number_format($report_vo->get_tot_push_booking_cnt()) ?></td>
				<td><?php echo number_format($report_vo->get_tot_request_cnt()) ?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>

	<div class="pagingList">
	<?php echo isset($paging) ? $paging : ''; ?>
	</div>
	</form>
</div>
<!-- //content-->
