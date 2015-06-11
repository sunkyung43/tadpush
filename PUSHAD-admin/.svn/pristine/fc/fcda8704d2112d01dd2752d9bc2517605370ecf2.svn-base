var chart;
var options;
  function draw_chart(data, category, name){
	 
	  if(data != null){
		  var category = category;
		  var series = data;
		  options = {
				  chart :{ 
						renderTo:'chart_area',
						type: 'line'
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
	
		  options.xAxis.categories = category;
		  options.series[0].name = name;
		  options.series[0].data = series;
		  
		 
		  chart = new Highcharts.Chart(options);
	  }
  }
   
  //조회 버튼 선택시
  function searchBtnClick(){
	  var search_type = $("#searchType option:selected").val();
	  var start_dt;
	  var end_dt;
	  var opt = true;
	  if(search_type != 'year'){
		  if($("#searchStartDate").val() != null){
			  start_dt = $("#searchStartDate").val();  
			  end_dt = $("#searchEndDate").val();
		  }else{
			  opt = false;
		  }
	  }
	   
	  var option_value = $("#searchType option:selected").val();
	  if(option_value == 'month'){
		  if(opt){
			  location.href='/statistics/periodStatistics/month?search_type='+search_type+'&start_dt='+start_dt+'&end_dt='+end_dt;
		  }else{
			  location.href='/statistics/periodStatistics/month?search_type='+search_type;
		  }
		 
	  }else if(option_value == 'day'){
		  if(opt){
			  location.href='/statistics/periodStatistics/day?search_type='+search_type+'&start_dt='+start_dt+'&end_dt='+end_dt;
		  }else{
			  location.href='/statistics/periodStatistics/day?search_type='+search_type;
		  }
	  }else{
		  location.href='/statistics/periodStatistics';
	  }
  } 
  