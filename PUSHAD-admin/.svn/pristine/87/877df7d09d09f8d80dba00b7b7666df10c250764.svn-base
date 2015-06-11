$(document).ready(function() {
	initValidate();

	changeInterface();
});

function initValidate() {
	$("#write_form").validate({
		ignore : "input[type='text']:hidden",
		rules : {
			"device_id" : {
				required : true
			},
			"media_id" : {
				required : true
			},
			"frequency_sq" : {
				required : true
			},
			"ad_sq" : {
				required : true
			},
			"campaign_sq" : {
				required : true
			}
		},
		messages : {
			device_id : "Device ID",
			media_id : "Media ID",
			frequency_sq : "Frequency SQ",
			ad_sq : "AD SQ",
			campaign_sq : "Campaign SQ"
		},
		errorPlacement : $.noop,
		invalidHandler : function(form, validator) {
			var name = validator.errorList[0].message;
			alert(name + '을(를) 확인해주세요.');
			validator.focusInvalid();
		}
	});

	$('#write_form').bind('submit', function(e) {
		if ($(".error").length == 0) {
			if (!confirm('ISF로 요청 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			} else {
				$("#isf_response").val('');
			}
		}
	});
}

function changeInterface() {
	// method selectbox
	methodSelectbox();
	
	// inputbox
	showInputbox();
}

function methodSelectbox() {
	$("#isf_method option").remove();
	
	var isf_interface = $("#isf_request_interface option:selected").val();

	switch (isf_interface) {
		case 'param':
		case 'param_media':
		case 'media':
		case 'ad':
		case 'campaign':
			addSelectboxOption('isf_method', 'POST');
			addSelectboxOption('isf_method', 'PUT');
			addSelectboxOption('isf_method', 'DELETE');
			break;
		case 'frequency':
			addSelectboxOption('isf_method', 'POST');
			addSelectboxOption('isf_method', 'DELETE');
			break;
		case 'count':
		case 'reserve':
		case 'down':
		case 'cancel':
		case 'status':
		case 'report':
			addSelectboxOption('isf_method', 'GET');
			break;
		default:
			break;
			
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

function showInputbox() {
	$(".parameterLayer").hide();
	
	var isf_interface = $("#isf_request_interface option:selected").val();
	
	switch (isf_interface) {
		case 'param':
			$("#device_id_layer").show();
			break;
		case 'param_media':
			$("#device_id_layer").show();
			$("#media_id_layer").show();
			break;
		case 'media':
			$("#media_id_layer").show();
			break;
		case 'ad':
			$("#ad_sq_layer").show();
			break;
		case 'campaign':
			$("#campaign_sq_layer").show();
			break;
		case 'frequency':
			$("#frequency_sq_layer").show();
			break;
		case 'count':
		case 'reserve':
		case 'down':
		case 'cancel':
		case 'status':
		case 'report':
			$("#ad_sq_layer").show();
			break;
		default:
			break;
			
	}
}

function isf_request() {
	$('#write_form').ajaxForm({
		dataType : 'text',
		success : function(json, statusText, xhr, $form) {
			$("#isf_response").val(json);
//			alert(json);
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});

	$("#write_form").attr('action', '/task/isfSync/isfRequest');
	$("#write_form").attr('method', 'GET');

	$('#write_form').submit();
}

function isf_sync() {
	if (!confirm('ISF로 요청 하시겠습니까?')) {
		return;
	}

	var params = new Object();
	params.isf_sync_interface = $("#isf_sync_interface option:selected").val();
	
	$("#isf_response").val('');
	
	$.ajax({
		type : "GET",
		url : "/task/isfSync/isfMetaSync",
		data : params,
		dataType : 'text',
		success : function(json) {
			$("#isf_response").val(json);
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}
