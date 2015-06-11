$(document).ready(function() {
	
	make_chart();	
});

var chart;
var options;
var type;
var value;

  function draw_chart(data, campaignName, adName, division_dt, sumName, report_type){
	  var division_dt = division_dt;
	  var campaignName = campaignName;
	  var series = data;
	  
	  if(report_type == 'campaign' || report_type == 'media'){
		  type = 'column';
		  if(report_type == 'campaign'){
			  value = adName;
		  }else{
			  value = adName;
		  }
	  }else{
		  type = 'line';
		  value = division_dt;
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
  
function search() {
		var params = $("#search_form").serialize();
	location.replace('/report/pcpMediaReport/detail?' + params);
}
 
function changeStartDate(start_dt) {
	$start_dt = start_dt.replace(/\./g,"-");
	$("#searchStartDate").val($start_dt);
}

function executeAction(campaign_sq) {
	window.open('/report/pcpCampaignReport/detail?type=popup&report_type=summery&campaign_sq=' + campaign_sq, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
}

function executeMediaAction(campaign_sq, ad_sq) {
	window.open('/report/pcpCampaignReport/detail?type=popup&report_type=media&ad_sq=' + ad_sq + '&campaign_sq=' + campaign_sq, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
}

