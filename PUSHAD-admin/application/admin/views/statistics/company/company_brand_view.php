<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#sortTable").tablesorter(
			{sortList : [ [1, 1 ] ], headers : {0 : {sorter : false}}
	});
});
//-->
</script>
<div id="content">
	<div class="subTitleArea">
		<h3>광고주</h3>
	</div>
	<form id="list_form" name="list_form">
	<!-- 검색 //-->
	<div class="searchArea">
		<strong class="title">등록일</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $search_start_dt;?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $search_end_dt;?>">
		<div class="n_search">
			<strong class="title">광고주 선택</strong>
			<?php echo $exist_company_list_selectbox;?>
			<strong class="title">브랜드 선택</strong>
			<?php echo $exist_brand_list_selectbox;?>
			<a href="javascript:list_form.submit();"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회"></a>
		</div>
	</div>
	<!--// 검색 -->

	<p class="dotLine"></p>
	<p style="margin:10px 0;">※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div class="searchArea02">
		<div class="n_class">
			<?php echo $paging_volume;?>
		</div>
		<p class="textRight"><span class="dataResult">총 <strong><?php echo $total_rows;?></strong>건의 데이터가 검색되었습니다.</span> 
		<a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a></p>
	</div>

	<table id="sortTable" class="compaingTable sortTable" summary="월별통계 리포트">
		<colgroup>
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th class="first">브랜드</th>
				<th style="background-position-x: 72%">시도 건수</th>
				<th style="background-position-x: 70%">성공 건수</th>
				<th style="background-position-x: 65%">성공율</th>
				<th style="background-position-x: 70%">Click 수</th>
				<th style="background-position-x: 65%" class="end">CTR</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!isset($list) || empty($list)): ?>
					<tr>
						<td colspan="6">조회결과가 없습니다.</td>
					</tr>
		<?php else: ?>
		<?php foreach($list as $statistics_vo): ?>
		<tr>
			<td>
				<a href="/statistics/companyStatistics/media?adv_company_sq=<?php echo $adv_company_sq;?>&adv_account_sq=<?php echo $statistics_vo->get_adv_account_sq();?>&search_start_dt=<?php echo $search_start_dt;?>&search_end_dt=<?php echo $search_end_dt;?>">
					<?php echo $statistics_vo->get_adv_brand_nm();?>
				</a>
			</td>
			<td><?php echo number_format($statistics_vo->get_request_cnt());?></td>
			<td><?php echo number_format($statistics_vo->get_success_cnt());?></td>
			<td><?php echo $statistics_vo->get_success_rate();?>%</td>
			<td><?php echo number_format($statistics_vo->get_click_cnt());?></td>
			<td><?php echo $statistics_vo->get_click_rate();?>%</td>
		</tr>
		<?php endforeach;?>
		<?php endif; ?>
		</tbody>
	</table>
	<p class="mg_t20">※ 선택한 등록일(광고주) 기간에 속하는 지표를 광고주의 브랜드 기준으로 산출하여 위 데이터를 제공합니다.</p>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>

	<div class="btnC">
		<span><a href="javascript:location.replace('/statistics/companyStatistics');"><img src="../../web/images/button/n_btn_list.gif" alt="목록"></a></span>
	</div>
	</form>
</div>