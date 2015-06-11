<script type="text/javascript">
<!--
var chart;
var options;

$(document).ready(function() {
	make_chart();

	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
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
		$.each(data, function (i, point) {
		    point.y = point.data;
		});
	
		var chart = new Highcharts.Chart({
	
		    chart: {
		        renderTo: 'chart_area',
		        type: 'pie'
		    },
			title: {
	            text: '통신사 통계'
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


//-->
</script>
<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>통신사</h3>
	</div>

	<form action="/statistics/carrierStatistics">
		<!-- 검색 //-->
		<div class="searchArea">
			<strong class="title">등록일</strong>
			<input id="searchStartDate" name="start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $start_dt?>">	 ~ 
			<input id="searchEndDate" name="end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $end_dt?>">
			<div class="n_search">
				<a href="#"><img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회" onclick="submit()"></a>
			</div>
		</div>
		<!--// 검색 -->
	</form>

	<p>※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div class="graphReport mg_b20" id="chart_area">
	</div>

	<table class="compaingTable" summary="통신사 별 발송 통계 리포트">
		<colgroup>
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<?php if (!isset($list) || empty($list)): ?>
		<thead>
			<tr>
				<th class="first">구분</th>
				<th>시도 건수</th>
				<th>성공 건수</th>
				<th>성공율</th>
				<th>Click 수</th>
				<th class="end">CTR</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="6">검색 결과가 없습니다.</td>
			</tr>
		</tbody>
		<?php else: ?>
		<thead>
			<tr>
				<th class="first">구분</th>
				<th><a href="javascript:make_chart('request')">시도 건수</a></th>
				<th><a href="javascript:make_chart('success')">성공 건수</a></th>
				<th><a href="javascript:make_chart('str')">성공율</a></th>
				<th><a href="javascript:make_chart('click')">Click 수</a></th>
				<th class="end"><a href="javascript:make_chart('ctr')">CTR</a></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $statistics_vo): ?>
			<tr>
				<td><?php echo $statistics_vo->get_carrier_nm()?></td>
				<td><?php echo number_format($statistics_vo->get_request_cnt())?></td>
				<td><?php echo number_format($statistics_vo->get_success_cnt())?></td>
				<td><?php echo $statistics_vo->get_success_rate()?>%</td>
				<td><?php echo number_format($statistics_vo->get_click_cnt())?></td>
				<td class="end"><?php echo $statistics_vo->get_click_rate()?>%</td>
			</tr>
			<?php endforeach;?>
		</tbody>
		<?php endif;?>
	</table>
	<div class="exelDown">
		<em>※ 선택한 기간에 속하는 지표를 단말기의 통신사(u_network_ operator) 정보를 기반으로 산출하여 위 데이터를 제공합니다.<br>※ ETC는 정보가 없거나(WIFI) 3사 통신사를 제외한 통신사를 의미합니다.</em>
		<a href="/statistics/carrierStatistics/excel?start_dt=<?php echo $start_dt?>&end_dt=<?php echo $end_dt?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
	</div>
</div>
<!-- //content-->