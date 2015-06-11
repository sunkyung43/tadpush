$(document).ready(function() {
	$('#mdn').live('keypress', function(e) {
		if (e.which == 13) {
			push();
		}
	});

	$('#mdn').focus();
});

function push() {
	if(!confirm('소재를 입력 한 MDN으로 발송합니다.')) {
		return;
	}
	
	var params = new Object();

	params.ad_sq = $("#ad_sq").val();
	params.mdn = $("#mdn").val();

	$.ajax({
		type : "POST",
		url : "/campaign/push",
		data : params,
		dataType : "json",
		success : function(json) {
			if (json.response_type == "success") {
				alert(json.response_data);
				window.close();
			} else {
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}
