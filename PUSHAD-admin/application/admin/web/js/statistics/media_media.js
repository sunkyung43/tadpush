/**
 * Device 통계용 js
 */

$(document).ready(function() {
	create_dual_calendar('#searchStartDate', '#searchEndDate', true);
	
	$("#sortTable").tablesorter(
			{
				sortList : [ [ 1, 1 ] ], 
				headers : {
					0 : {sorter : false},
					1 : {sorter : 'fancyNumber'}, 
					2 : {sorter : 'fancyNumber'}, 
					3 : {sorter : 'fancyNumber'}, 
					4 : {sorter : 'fancyNumber'},
					5 : {sorter : 'fancyNumber'}
			}
	});
});



