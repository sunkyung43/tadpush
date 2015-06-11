<script type="text/javascript">
<!--
$(document).ready(function() {
	create_dual_calendar('#searchStartDate', '#searchEndDate', true);

	$.tablesorter.addParser({
        id: 'fancyNumber',
        is:function(s){return false;},
        format: function(s) {return s.replace(/[\,\%]/g,'');},
        type: 'numeric'
    	});
	
	$("#sortTable").tablesorter(
			{
				sortList : [ [2, 1 ] ], 
				headers : {
					0 : {sorter : false}, 
					1:{sorter:false},
					2 : {sorter : 'fancyNumber'}, 
					3 : {sorter : 'fancyNumber'}, 
					4 : {sorter : 'fancyNumber'},
					5 : {sorter : 'fancyNumber'},
					5 : {sorter : 'fancyNumber'}
					}
	});
});
//-->
</script>
<div id="content">
	<div class="subTitleArea">
		<h3>소재</h3>
	</div>
	<form id="list_form" name="list_form">
	<!-- 검색 //-->
	<div class="searchArea">
		<strong class="title">등록일</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $search_start_dt;?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $search_end_dt;?>">
		<div class="n_search">
			<a href="javascript:list_form.submit();"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회"></a>
		</div>
	</div>
	<!--// 검색 -->

	<p class="dotLine"></p>
	<p style="margin:10px 0;">※ 조회 일시 : 2013/07/23 12:39</p>
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
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th class="first">광고 명</th>
				<th>Ticket Text</th>
				<th style="background-position-x: 78%;">시도 건수</th>
				<th style="background-position-x: 78%;">성공 건수</th>
				<th style="background-position-x: 75%;">성공율</th>
				<th style="background-position-x: 75%;">Click 수</th>
				<th style="background-position-x: 70%;" class="end">CTR</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="7">조회결과가 없습니다.</td>
				</tr>
			<?php else: ?>
			<?php foreach($list as $statistics_vo): ?>
			<tr>
				<td><?php echo $statistics_vo->get_ad_nm();?></td>
				<td><?php echo $statistics_vo->get_ticket_text();?></td>
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
	<p class="mg_t20">※ 선택한 등록일(소재) 기간에 속하는 지표를 Click 지표가 높은 순으로 산출하여 위 데이터를 제공합니다.</p>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>
	</form>
</div>