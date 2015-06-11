$(document).ready(function() {
	initValidate();

	$("#ad_nm").displayBytes(80, "ad_nm_validate");
	
	$("#push_booking_cnt").ForceNumericOnly(100000000);
	
	initCalendar();
	
	$('#ad_nm').focus();
});

function initValidate() {
	$("#write_form").validate({
		ignore : "input[type='text']:hidden",
		rules : {
			"ad_nm" : {
				required : true
			},
			"push_booking_cnt" : {
				required : true
			},
			"start_dt" : {
				required : true
			},
			"start_time" : {
				required : true
			}
		},
		messages : {
			ad_nm : "광고 명",
			push_booking_cnt : "발송 건수",
			start_dt : "발송 일자",
			start_time : "발송 시간"
		},
		errorPlacement: $.noop,
		invalidHandler : function(form, validator) {
			var name = validator.errorList[0].message;
			alert(name + '을(를) 확인해주세요.');
			validator.focusInvalid();
		}
	});
	
	$('#write_form').bind('submit',function(e){
		if($(".error").length == 0) {
			if (!confirm('등록 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
		}
	});

}

function initCalendar() {
	var calendar_min_day = $("#calendar_min_day").val();
	var calendar_max_week = $("#calendar_max_week").val();
	create_single_calendar('start_dt', calendar_max_week, calendar_min_day);

	$("#start_dt").change(function() {
		var params = new Object();

		params.start_dt = $("#start_dt").val();
		params.start_time = $("#start_time").val();

		$.ajax({
			type : "GET",
			url : "/campaign/advert/timeSelectbox",
			data : params,
			dataType : "json",
			success : function(json) {
				if (json.response_type == "success") {
					$("#time_selectbox_layer").html(json.response_data);
				} else {
					alert(json.response_data);
				}
			},
			error : function(data) {
				alert("요청에 실패하였습니다." + data.responseText);
			}
		});
	});
}

function advert_write() {
	var params = new Object();
	
	params.ad_nm = $("#ad_nm").val();
	
	$('#write_form').ajaxForm({
		dataType : 'json',
		data : params,
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") 
			{
				location.replace(json.response_data);
			}
			else 
			{
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});

	$("#write_form").attr('action', '/campaign/advert');
	$("#write_form").attr('method', 'POST');

	$('#write_form').submit();
}

function advert_cancel() {
	if (confirm('등록 중이던 모든 정보가 삭제 됩니다. 취소 하시겠습니까?')) {
		location.replace('/campaign/advert');
	}
}
