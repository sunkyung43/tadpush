function search() {
	var params = $("#list_form").serialize();
	location.replace('/campaign/campaign?' + params);
}

function execute() {
	var execute_type = $("#execute_type").val();

	if (execute_type == '') {
		return;
	}

	var campaign_sq = $(":radio[name='campaign_sq']:checked").val();
	if (typeof (campaign_sq) == 'undefined') {
		alert('캠페인을 선택하세요.');
		return;
	}

	if (!confirm('캠페인을 삭제합니다.')) {
		return;
	}
	
	$.ajax({
		type : "DELETE",
		url : "/campaign/campaign",
		data : {
			'campaign_sq' : campaign_sq
		},
		dataType : "json",
		success : function(json) {
			if (json.response_type == "success") {
				alert(json.response_data);
				location.reload();
			} else {
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
			location.reload();
		}
	});
}