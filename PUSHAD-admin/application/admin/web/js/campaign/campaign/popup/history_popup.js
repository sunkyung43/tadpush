$(document).ready(function() {
	$(".input_comment").focusout(function() {
		if ($("#" + this.id).val() != $("#" + this.id + "_org").val()) {
			if (confirm('입력한 내용을 저장합니다.')) {
				history_write(this.id);
			}
		}
	});
});

function changeListType() {
	var params = $("#list_form").serialize();
	location.replace('/campaign/campaign/history?' + params);
}

function history_write(id) {
	var temp = id.split("_");
	var campaign_history_sq = temp[2];

	var history_comment = $("#" + id).val();
	$.ajax({
		type : "PUT",
		url : "/campaign/campaign/history",
		data : {
			'campaign_history_sq' : campaign_history_sq,
			'history_comment' : history_comment
		},
		dataType : "json",
		success : function(json) {
			$("#" + id + "_org").val(history_comment);
			alert(json.response_data);
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}