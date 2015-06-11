$(document).ready(function() {
	initValidate();

	$("#frequency_cnt").ForceNumericOnly(7);
	
	initCalendar();
	
	AddFrequencySelectbox();
});

function initValidate() {
	$("#write_form").validate({
		ignore : "input[type='text']:hidden",
		rules : {
			"cycle" : {
				required : true
			},
			"frequency_cnt" : {
				required : true
			},
			"start_dt" : {
				required : true
			}
		},
		messages : {
			cycle : "주기설정",
			frequency_cnt : "Frequency 설정",
			start_dt : "적용일자"
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
	create_frequency_calendar('start_dt', calendar_min_day);
}

function AddFrequencySelectbox() {
	return;
	
	$("#frequency_cnt option").remove();
	
	var cycle = $("#cycle option:selected").val();
	
	for(frequency_cnt = 1; frequency_cnt <= cycle; frequency_cnt++) {
		addSelectboxOption('frequency_cnt', frequency_cnt);
	}
}

function addSelectboxOption(selectboxID, optionValue) {
	var option = new Option(optionValue, optionValue);
	if ($.browser.msie) {
		document.getElementById(selectboxID).add(option);
	} else {
		document.getElementById(selectboxID).add(option, null);
	}
}

function push_setting_write() {
	$('#write_form').ajaxForm({
		dataType : 'json',
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") {
				location.replace(json.response_data);
			} else {
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});

	$("#write_form").attr('action', '/system/pushSetting');
	$("#write_form").attr('method', 'POST');

	$('#write_form').submit();
}

function push_setting_cancel() {
	if (confirm('등록 중이던 모든 정보가 삭제 됩니다. 취소 하시겠습니까?')) {
		location.replace('/system/pushSetting');
	}
}