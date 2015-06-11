$(document).ready(function() {
	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
});

function search()
{
	if($("#search_type").val() == 'age'){
		$("#list_form").attr('action', '/statistics/humanStatistics/age');
		$("#list_form").attr('method', 'GET');
		$("#list_form").submit();
	}
	else{
		$("#list_form").submit();
	}
}