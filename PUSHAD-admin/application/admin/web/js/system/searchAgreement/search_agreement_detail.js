$(document).ready(function() {
	$('#mdn').live('keypress', function(e) {
		if (e.which == 13) {
			search();
		}
	});

	if ($("#mdn").val() != '' && $("#search_result").val() != 'true') {
		alert("해당 MDN이 존재하지 않습니다.");
	}
	
	$('#mdn').focus();
});

function search() {
	if ($("#mdn").val() == '') {
		alert("MDN을 입력해 주세요.");
		return;
	}

	var params = $("#list_form").serialize();
	location.replace('/system/searchAgreement?' + params);
}

function mdn_recant(mdn) {
	if (!confirm("동의 철회 처리를 하시겠습니까?")) {
		return;
	}

	var params = new Object();
	
	params.mdn = mdn;
	params.device_id = $("#device_id").val();
	params.carrier = $("#carrier").val();
	params.media_id = $("#media_id").val();

	$.ajax({
		type : "PUT",
		url : "/system/searchAgreement/recant",
		data : params,
		dataType : "json",
		success : function(json) {
			if (json.response_type == "success") {
				alert(json.response_data);
				var params = $("#list_form").serialize();
				location.replace('/system/searchAgreement?' + params);
			} else {
				alert(json.response_data);
			}

		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}
