<script type="text/javascript">
<!--
var chart;
var options;

$(document).ready(function() {
	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
	make_chart();
});

function make_chart(division){
	switch(division){
		case 'request':
			draw_chart(eval(<?php echo $request_chart?>));
			break;
		case 'success':
			draw_chart(eval(<?php echo $success_chart?>));
			break;
		case 'str':
			draw_chart(eval(<?php echo $str_chart?>));
			break;
		case 'click':
			draw_chart(eval(<?php echo $click_chart?>));
			break;
		case 'ctr':
			draw_chart(eval(<?php echo $ctr_chart?>));
			break;
		default:
			draw_chart(eval(<?php echo $request_chart?>));
	}
}

function draw_chart(jsonData){
	var data = jsonData;
	if(data != null){
		// Highcharts requires the y option to be set

		var categories = [];
		$.each(data, function (i, point) {
		    point.y = point.data;
		    categories.push(point.name);
		});
	
		var chart = new Highcharts.Chart({
	
		    chart: {
		        renderTo: 'chart_area',
		        type: 'column'
		    },
			title: {
	            text: ''
	        },
	        xAxis: {
	            categories: categories
	        },
	        plotOptions: {
		       	 column: {
		             allowPointSelect: true,
		             cursor: 'pointer',
		             dataLabels: {
		                 enabled: true
		             },
		             showInLegend: false
		         }
	        },
		    series: [{
		        data: data
		    }]
			
		});
	}
}

//-->
</script>
<div id="content">
	<div class="subTitleArea">
		<h3>OS</h3>
	</div>

	<!-- 검색 //-->
	<form id="list_form" name="list_form">
	<div class="searchArea">
		<strong class="title">기간</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $search_start_dt?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $search_end_dt;?>">
		<div class="n_search">
			<strong class="title">OS</strong>
			<?php echo $os_type_selectbox;?>
			<a href="javascript:list_form.submit()"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회"></a>
		</div>
	</div>
	<!--// 검색 -->

	<p>※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div class="graphReport mg_b20" id="chart_area">
	</div>

	<table class="compaingTable" summary="통계 리포트">
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
				<td><?php echo $statistics_vo->get_os_ver_nm(); ?></td>
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
			<em>※ 선택한 기간에 속하는 지표를 단말기의 OS(d_os_ver)정보를 기반으로 산출하여 위 데이터를 제공합니다.</em>
			<a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
	</div>
</form>
</div>