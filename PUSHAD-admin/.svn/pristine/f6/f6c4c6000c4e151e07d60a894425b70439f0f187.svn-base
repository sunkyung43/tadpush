<script type="text/javascript">
<!--

var chart;
var options;

$(document).ready(function() {
	make_chart();
});

function make_chart(division){
	switch(division){
		case 'request':
			draw_chart(eval(<?php echo $chart_data['request_chart'];;?>));
			break;
		case 'success':
			draw_chart(eval(<?php echo $chart_data['success_chart'];?>));
			break;
		case 'str':
			draw_chart(eval(<?php echo $chart_data['str_chart'];?>));
			break;
		case 'click':
			draw_chart(eval(<?php echo $chart_data['click_chart'];?>));
			break;
		case 'ctr':
			draw_chart(eval(<?php echo $chart_data['ctr_chart'];?>));
			break;
		default:
			draw_chart(eval(<?php echo $chart_data['request_chart'];?>));
	}
}

function draw_chart(jsonData){
	var data = jsonData;
	if(data != null){
		// Highcharts requires the y option to be set
		$.each(data, function (i, point) {
		    point.y = point.data;
		});
	
		var chart = new Highcharts.Chart({
	
		    chart: {
		        renderTo: 'chart_area',
		        type: 'pie'
		    },
			title: {
	            text: '인구통계학'
	        },
	        plotOptions: {
		       	 pie: {
		             allowPointSelect: true,
		             cursor: 'pointer',
		             dataLabels: {
		                 enabled: true,
		                 format: '<b>{point.name}</b>: {point.percentage:.1f} %'
		             },
		             showInLegend: true
		         }
	        },
		    series: [{
		        data: data
		    }]
	
		});
	}
}

function executeDetail(type)
{
	$("#search_value").val(type);
	$("#list_form").attr('action', '/statistics/humanStatistics/age');
	$("#list_form").attr('method', 'GET');
	$("#list_form").submit();
}
//-->
</script>
<div id="content">
	<div class="subTitleArea">
		<h3>인구통계학</h3>
	</div>
	<form id="list_form" name="list_form">
	<input type="hidden" id="search_value" name="search_value">
	<!-- 검색 //-->
	<div class="searchArea">
		<strong class="title">기간</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $search_start_dt;?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $search_end_dt;?>">
		<div class="n_search">
			<strong class="title">구분</strong>
			<select id="search_type">
				<option value="gender">성별</option>
				<option value="age">나이</option>
			</select>
			<a href="javascript:search();"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회"></a>
		</div>
	</div>
	<!--// 검색 -->

	<p class="dotLine"></p>
	<p>※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div id="chart_area" class="graphReport mg_b20">
		
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
				<td colspan="6">조회결과가 없습니다.</td>
			</tr>
			<?php else: ?>
			<?php foreach($list as $statistics_vo): ?>
			<tr>
				<td><a href="javascript:executeDetail('<?php echo $statistics_vo->get_gender_cd()?>')"><?php echo $statistics_vo->get_division_nm();?></a></td>
				<td><?php echo $statistics_vo->get_request_cnt();?></td>
				<td><?php echo $statistics_vo->get_success_cnt();?></td>
				<td><?php echo $statistics_vo->get_success_rate();?></td>
				<td><?php echo $statistics_vo->get_click_cnt();?></td>
				<td><?php echo $statistics_vo->get_click_rate();?></td>
			</tr>
			<?php endforeach;?>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="exelDown">
		<em>※ 선택한 기간에 속하는 지표를 ISF가 제공하는 성별 정보를 기반으로 산출하여 위 데이터를 제공합니다.</em>
		<a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
	</div>
	</form>
</div>