<script type="text/javascript">
<!--
$(document).ready(function() {
	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
});
//-->
</script>
<div id="content">
	<div class="subTitleArea">
		<h3>모수</h3>
	</div>
	<form id="list_form" name="list_form">
	<!-- 검색 //-->
	<div class="searchArea">
		<strong class="title">기간</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $search_start_dt;?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $search_end_dt;?>">
		<div class="n_search">
			<a href="javascript:list_form.submit();"><img id="BTN_SEARCH" src="../../web/images/button/check02.gif" alt="확인"></a>
		</div>
	</div>
	<!--// 검색 -->

	<p class="dotLine"></p>

	<div class="searchArea02">
		<div class="n_class">
			<?php echo $paging_volume;?>
		</div>
		<div class="n_search">
			<a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
		</div>
	</div>

	<table class="compaingTable" summary="월별통계 리포트">
		<colgroup>
			<col width="25%">
			<col width="">
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th class="first">일자</th>
				<th>모수</th>
				<th>증감</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
					<tr>
						<td colspan="3">조회결과가 없습니다.</td>
					</tr>
			<?php else: ?>
			<?php foreach($list as $statistics_vo): ?>
			<tr>
				<td><?php echo $statistics_vo->get_division_dt();?></td>
				<td><?php echo number_format($statistics_vo->get_param_cnt());?></td>
				<td><?php echo number_format($statistics_vo->get_variation_cnt());?></td>
			</tr>
			<?php endforeach;?>
			<?php endif; ?>
		</tbody>
	</table>
	<p class="mg_t20">※ 선택한 기간에 속하는 모수를 일별로 합산된 합계와 증감 현황을 산출하여 위 데이터를 제공합니다.</p>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>
	</form>
</div>