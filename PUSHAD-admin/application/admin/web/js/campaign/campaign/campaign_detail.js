function campaignHistory(campaign_sq) {
	window.open('/campaign/campaign/history?campaign_sq=' + campaign_sq, 'campaignHistoryPopup', 'width=1200, height=600, left=50, top=50, scrollbars=yes');
}

function execute() {
	var execute_type = $("#execute_type").val();

	if (execute_type == '') {
		return;
	}

	var ad_sq = $(":radio[name='ad_sq']:checked").val();
	if (typeof (ad_sq) == 'undefined') {
		alert('광고를 선택하세요.');
		return;
	}
	
	var ad_status_cd = $("#ad_status_cd_" + ad_sq).val();
	if(ad_status_cd == execute_type) {
		if(execute_type == 'PSEADST01') {
			alert('현재 검수 상태입니다..');
		} else if (execute_type == 'PSEADST02'){
			alert('현재 발송대기 상태입니다.');
		}
		return;
	}

	if(execute_type == 'PSEADST01') {
		if (!confirm('검수 상태로 변경합니다.')) {
			return;
		}
	} else if (execute_type == 'PSEADST02'){
		if (!confirm('발송대기 상태로 변경합니다.')) {
			return;
		}
	}
	
	$.ajax({
		type : "PUT",
		url : "/campaign/advert/status",
		data : {
			'ad_status_cd' : execute_type,
			'ad_sq' : ad_sq
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
