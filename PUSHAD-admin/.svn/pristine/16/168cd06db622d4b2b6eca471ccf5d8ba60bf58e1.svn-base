$(document).ready(function() {
	$('#mdn').live('keypress', function(e) {
		if (e.which == 13) {
			search();
		}
	});
	
	$('#mdn').focus();
});

function search() {
	if ($("#mdn").val() == '') {
		alert("MDN을 입력해 주세요.");
		return;
	}
	
	var params = $("#list_form").serialize();
	location.replace('/system/pushHistory?' + params);
}
