<script type="text/javascript">
<!--

$(document).ready(function() {
	make_chart();

	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
});

function make_chart(division){
	switch(division){
		case 'request':
			draw_chart(eval(<?php echo $chart_data['request_cnt']?>), eval(<?php echo $chart_data['division_dt'] ?>),'시도건수');
			break;
		case 'success':
			draw_chart(eval(<?php echo $chart_data['success_cnt']?>), eval(<?php echo $chart_data['division_dt'] ?>),'성공건수');
			break;
		case 'str':
			draw_chart(eval(<?php echo $chart_data['success_rate']?>), eval(<?php echo $chart_data['division_dt'] ?>),'성공률');
			break;
		case 'click':
			draw_chart(eval(<?php echo $chart_data['click_cnt']?>), eval(<?php echo $chart_data['division_dt'] ?>),'클릭수');
			break;
		case 'ctr':
			draw_chart(eval(<?php echo $chart_data['click_rate']?>), eval(<?php echo $chart_data['division_dt'] ?>),'CTR');
			break;
		default:
			draw_chart(eval(<?php echo $chart_data['success_cnt']?>), eval(<?php echo $chart_data['division_dt'] ?>),'성공건수');
	}
}
//-->
</script>
<div id="content">
		<div class="subTitleArea">
			<h3>기간 별 통계</h3>
		</div>

		<!-- 검색 //-->
		<div class="searchArea">
			<strong class="title">기간</strong>
			<input id="searchStartDate" name="searchStartDate" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $start_dt?>">
			~
			<input id="searchEndDate" name="searchEndDate" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $end_dt?>">
			<div class="n_search">
			<strong class="title">구분</strong> 
			<select id="searchType">
				<option value="year">년도</option>
				<option value="month" selected>월별</option>
				<option value="day">일별</option>
			</select><a href="javascript:searchBtnClick()"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회"></a>
		</div>
		</div>
	
		<!--// 검색 -->

		<p>※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
		<div class="graphReport mg_b20" id="chart_area"></div>

		<table class="compaingTable" summary="월별통계 리포트">
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
					<th class="first">구분</th>
					<th><a href="javascript:make_chart('request')">시도 건수</a></th>
					<th><a href="javascript:make_chart('success')">성공 건수</a></th>
					<th><a href="javascript:make_chart('str')">성공률</a></th>
					<th><a href="javascript:make_chart('click')">클릭수</a></th>
					<th class="end"><a href="javascript:make_chart('ctr')">CTR</a></th>
				</tr>
			</thead>
			<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="6">검색결과가 없습니다.</td>
				</tr>
			<?php else: ?>
				<?php foreach($list as $statistics_vo): ?>
			<tr>
					<td><a href="/statistics/periodStatistics/day?search_type=day&start_dt=<?php echo $statistics_vo->get_division_dt() ?>"><?php echo $statistics_vo->get_division_dt() ?></a></td>
					<td><?php echo number_format($statistics_vo->get_request_cnt()); ?></td>
					<td><?php echo number_format($statistics_vo->get_success_cnt()); ?></td>
					<td><?php echo $statistics_vo->get_success_rate(); ?>%</td>
					<td><?php echo number_format($statistics_vo->get_click_cnt()); ?></td>
					<td class="end"><?php echo $statistics_vo->get_click_rate(); ?>%</td>
				</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
		<div class="exelDown">
			<em>※ 선택한 기간에 속하는 지표를 월별 기준으로 산출하여 위 데이터를 제공합니다.</em>
			<a href="/statistics/periodStatistics/excel?search_type=month&start_dt=<?php echo $start_dt?>&end_dt=<?php echo $end_dt?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
		</div>
	</div>