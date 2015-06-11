<script type="text/javascript">
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

function executeDetail($category_cd){
	
	
}

</script>

<div id="content">
	<div class="subTitleArea">
		<h3>미디어</h3>
	</div>

	<!-- 검색 //-->
	<div class="searchArea">
		<form id="search_form" name="search_form">
		<input type="hidden" id="media_category_cd" name="media_category_cd">
		<strong class="title">등록일</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $start_dt;?>"> 
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $end_dt?>"> 
		<div class="n_search">
			<img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회" style="cursor: pointer;" onclick="javascript: search_form.submit()">
		</div>
		</form>
	</div>

	<p class="mg_b10">※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div class="graphReport mg_b20" id="chart_area">
	</div>


	<table class="compaingTable" summary="월별통계 리포트">
		<colgroup>
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th class="first">카테고리</th>
				<th><a href="javascript:make_chart('request')">시도 건수</a></th>
				<th><a href="javascript:make_chart('success')">성공 건수</a></th>
				<th><a href="javascript:make_chart('str')">성공률</a></th>
				<th><a href="javascript:make_chart('click')">클릭수</a></th>
				<th class="end"><a href="javascript:make_chart('ctr')">CTR</a></th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($total) || empty($total)): ?>
			<tr>
				<td><a href="/statistics/mediaStatistics/media?search_start_dt=<?php echo $start_dt?>&search_end_dt=<?php echo $end_dt?>">전체</a></td>
				<td>0</td>
				<td>0</td>
				<td>0%</td>
				<td>0</td>
				<td class="end">0%</td>
			</tr>
			<?php else: ?>
			<tr>
				<td><a href="/statistics/mediaStatistics/media?search_start_dt=<?php echo $start_dt?>&search_end_dt=<?php echo $end_dt?>">전체</a></td>
				<td><?php echo number_format($total->get_request_cnt());?></td>
				<td><?php echo number_format($total->get_success_cnt());?></td>
				<td><?php echo $total->get_success_rate();?>%</td>
				<td><?php echo number_format($total->get_click_cnt());?></td>
				<td class="end"><?php echo $total->get_click_rate();?>%</td>
			</tr>
			<?php foreach($list as $statistics_vo): ?>
			<tr>
				<td><a href="/statistics/mediaStatistics/media?search_start_dt=<?php echo $start_dt?>&search_end_dt=<?php echo $end_dt?>&media_category_cd=<?php echo $statistics_vo->get_media_category_cd();?>"><?php echo $statistics_vo->get_media_category_nm();?></a></td>
				<td><?php echo number_format($statistics_vo->get_request_cnt());?></td>
				<td><?php echo number_format($statistics_vo->get_success_cnt());?></td>
				<td><?php echo $statistics_vo->get_success_rate();?>%</td>
				<td><?php echo number_format($statistics_vo->get_click_cnt());?></td>
				<td class="end"><?php echo $statistics_vo->get_click_rate();?>%</td>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
	<div class="exelDown">
		<em>※ 선택한 등록일(미디어) 기간에 속하는 지표를 미디어 카테고리 기준으로 산출하여 위 데이터를 제공합니다.</em>
		<a href="/statistics/mediaStatistics/excel?search_start_dt=<?php echo $start_dt;?>&search_end_dt=<?php echo $end_dt;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
	</div>
</div>