$(document).ready(function() {
	
	create_dual_calendar('#searchStartDate', '#searchEndDate');
	
	make_chart();	
	
	changeReportType();
	
});

var chart;
var options;
var type;
var value;

  function draw_chart(data, adName, mediaName, division_dt, sumName, report_type, ad_report_type, ad_sq){
	  var division_dt = division_dt;
	  var adName = adName;
	  var series = data;
	  
	  if(ad_sq == ''){
		  type = 'column';
		  if(report_type == 'summery'){
			  value = adName;
		  }
		  if(report_type == 'month' || report_type == 'daily'){
			  type = 'line';
			  value = division_dt;
		  }
		  if(report_type == 'media'){
			  value = mediaName;
		  }
	  }else{
		  type = 'column';
		  value = mediaName;
	  }
		  
	  options = {
			  chart :{ 
					renderTo:'chart_area',
					type: type
				},
				title: {
		            text: ''
		        },
		        xAxis: {
		        	 title: {
		                    text: ''
		                },
		                categories: []
		        },
		        yAxis: {
	                title: {
	                    text: ''
	                },
	            },
	            legend: {
	               enabled:false
		               	},
				series: [{}]
		  };
	  
	  options.xAxis.categories = value;
	  options.series[0].name = sumName;
	  options.series[0].data = series;
	  
	  chart = new Highcharts.Chart(options);
  }
  
function changeReportType() {

	$ad_sq = $("select[name=ad_sq]").val();
	
	$("#ad_report_type").hide();
	$("#report_type").show();
		
	if($ad_sq == null || $ad_sq == ''){
		$("#report_type").show();
		$("#ad_report_type").hide();
		
		calendar();
		
		$("#searchStartDate").datepicker('enable');
		$("#searchEndDate").datepicker('enable');
		
	}else{
		if($("select[name=ad_report_type]").val() == 'media'){
			$("#ad_report_type").show();
			$("#report_type").hide();
		}else{
			$("#ad_report_type").show();
			$("#report_type").hide();
			
			$("#graphReport").remove();
		}
		$("#searchStartDate").datepicker('disable');
		$("#searchEndDate").datepicker('disable');
	}
}

function executeAction(media_id) {
	window.open('/report/pcpMediaReport/detail?type=popup&media_id=' + media_id, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
}
