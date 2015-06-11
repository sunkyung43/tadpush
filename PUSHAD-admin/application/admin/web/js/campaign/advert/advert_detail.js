function init() {
	initValidateEvent();
	initValidateRules();
	setBindForm(true);

	$("#ad_nm").displayBytes(80, "ad_nm_validate");

	$("#push_booking_cnt").ForceNumericOnly();

	initCalendar();

	initLandingType();

	initTargetMedia();

	creative_type_cd = $("#creative_type_cd").val();
	if (creative_type_cd == 'PSCTTP107' || creative_type_cd == 'PSCTTP108'
			|| creative_type_cd == 'PSCTTP109'
			|| creative_type_cd == 'PSCTTP110') {
		selectCreativeJB(true);
	}

	checkRegionCode();

	bindCreativeEvent();
	
	checkFreezing();
}

function initValidateEvent() {
	$("#write_form").bind('invalid-form.validate', function(form, validator) {
		var name = validator.errorList[0].message;
		alert(name + '을(를) 확인해주세요.');
		if (validator.errorList[0].element.name.indexOf('image') < 0) {
			validator.errorList[0].element.focus();
		} else {
			$("#" + validator.errorList[0].element.id + "_file").focus();
		}
	});
}

function initValidateRules() {
	$("#write_form").removeData("validator");

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
			},
			"creative_type_cd" : {
				required : true
			},
			"ticket_text" : {
				required : true
			},
			"large_icon_image" : {
				required : true
			},
			"banner_image" : {
				required : true
			},
			"popup_image" : {
				required : true
			},
			"content_title" : {
				required : true
			},
			"content_text" : {
				required : true
			},
			"sub_text" : {
				required : true
			},
			"landing_type_cd" : {
				required : true
			},
			"landing_type_url" : {
				required : true
			},
			"and_run_url" : {
				required : true
			},
			"tst_dl_url" : {
				required : true
			},
			"mar_dl_url" : {
				required : true
			},
			"popup_title" : {
				required : true
			},
			"popup_content_text" : {
				required : true
			},
			"landing_button_title" : {
				required : true
			},
			"inbox_text_line_1" : {
				required : true
			},
			"action1_landing_type_url" : {
				required : true
			},
			"action1_and_run_url" : {
				required : true
			},
			"action1_tst_dl_url" : {
				required : true
			},
			"action1_mar_dl_url" : {
				required : true
			},
			"action2_landing_type_url" : {
				required : true
			},
			"action2_and_run_url" : {
				required : true
			},
			"action2_tst_dl_url" : {
				required : true
			},
			"action2_mar_dl_url" : {
				required : true
			},
			"action3_landing_type_url" : {
				required : true
			},
			"action3_and_run_url" : {
				required : true
			},
			"action3_tst_dl_url" : {
				required : true
			},
			"action3_mar_dl_url" : {
				required : true
			}
		},
		messages : {
			ad_nm : "광고 명",
			push_booking_cnt : "발송 건수",
			start_dt : "발송 일자",
			start_time : "발송 시간",
			creative_type_cd : "소재 정보",
			ticket_text : "Ticket Text",
			large_icon_image : "Large Icon",
			banner_image : "Banner Image",
			popup_image : "Popup Image",
			content_title : "Content Title",
			content_text : "Content Text",
			sub_text : "Sub Text",
			landing_type_cd : "Landing Type",
			landing_type_url : "Landing URL",
			and_run_url : "App 실행 URL",
			tst_dl_url : "T Store D/L URL",
			mar_dl_url : "Google Play D/L URL",
			popup_title : "Popup Title",
			popup_content_text : "Popup Content Text",
			landing_button_title : "Landing Button Title",
			inbox_text_line_1 : "Inbox Text Line 1",
			action1_landing_type_url : "Action1 Landing URL",
			action1_and_run_url : "Action1 App 실행 URL",
			action1_tst_dl_url : "Action1 T Store D/L URL",
			action1_mar_dl_url : "Action1 Google Play D/L URL",
			action2_landing_type_url : "Action2 Landing URL",
			action2_and_run_url : "Action2 App 실행 URL",
			action2_tst_dl_url : "Action2 T Store D/L URL",
			action2_mar_dl_url : "Action2 Google Play D/L URL",
			action3_landing_type_url : "Action3 Landing URL",
			action3_and_run_url : "Action3 App 실행 URL",
			action3_tst_dl_url : "Action3 T Store D/L URL",
			action3_mar_dl_url : "Action3 Google Play D/L URL"
		},
		errorPlacement : $.noop
	});
}

function eventSubmit(e) {
	if ($(".error").length == 0) {
		if (!checkURL()) {
			alert('정상적인 URL이 아닙니다. 확인해 주세요.');
			e.preventDefault ? e.preventDefault() : e.returnValue = false;
			return;
		}

		var ad_status_cd = $("#ad_status_cd").val();
		var msg = '';
//		if(ad_status_cd == 'PSEADST02') {
//			msg = '검수 상태로 변경됩니다. 수정 하시겠습니까?';
//		} else {
			msg = '수정 하시겠습니까?';
//		}
		if (!confirm(msg)) {
			e.preventDefault ? e.preventDefault() : e.returnValue = false;
		}
	}
}

function checkURL() {
	var url_id_list = new Array("landing_type_url",
			"tst_dl_url", "mar_dl_url", "action1_landing_type_url",
			"action1_tst_dl_url", "action1_mar_dl_url",
			"action2_landing_type_url",
			"action2_tst_dl_url", "action2_mar_dl_url",
			"action3_landing_type_url",
			"action3_tst_dl_url", "action3_mar_dl_url");

	size = url_id_list.length;

	var id = '';

	for (i = 0; i < size; i++) {
		id = url_id_list[i]
		if ($("#" + id).length > 0 && $("#" + id).is(":visible")) {
			if (!isValidUrl($("#" + id).val())) {
				$("#" + id).focus();
				return false;
			}
		}
	}

	return true;
}

function setBindForm(isBind) {
	if (isBind == true) {
		$('#write_form').bind('submit', eventSubmit);
	} else {
		$('#write_form').unbind('submit');
	}
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

function initLandingType() {
	$(".landing_type_radio").change(function() {
		$("." + this.name + "_1_layer").hide();
		$("." + this.name + "_2_layer").hide();
		$("." + this.name + "_3_layer").hide();
		$("." + this.name + "_4_layer").hide();
		$("." + this.id + "_layer").show();
	});

	$(".landing_type_radio").each(function() {
		if ($("#" + this.id + ":checked").length > 0) {
			$("#" + this.id).change();
		}
	});
}

function bindCreativeEvent() {
	var creative_type_cd = $("#creative_type_cd").val();
	if (creative_type_cd == '') {
		return;
	}

	$("#ticket_text").displayBytes(45, "ticket_text_validate");

	if (creative_type_cd == 'PSCTTP101') {
		// text
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#sub_text").displayBytes(25, "sub_text_validate");
	} else if (creative_type_cd == 'PSCTTP102') {
		// image
	} else if (creative_type_cd == 'PSCTTP103') {
		// popup text banner
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#popup_title").displayBytes(20, "popup_title_validate");
		$("#popup_content_text").displayBytes(100,
				"popup_content_text_validate");
		$("#landing_button_title").displayBytes(10,
				"landing_button_title_validate");
	} else if (creative_type_cd == 'PSCTTP104') {
		// popup text
		$("#popup_title").displayBytes(20, "popup_title_validate");
		$("#popup_content_text").displayBytes(100,
				"popup_content_text_validate");
		$("#landing_button_title").displayBytes(10,
				"landing_button_title_validate");
	} else if (creative_type_cd == 'PSCTTP105') {
		// popup image banner
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#landing_button_title").displayBytes(10,
				"landing_button_title_validate");
	} else if (creative_type_cd == 'PSCTTP106') {
		// popup iamge
		$("#landing_button_title").displayBytes(10,
				"landing_button_title_validate");
	} else if (creative_type_cd == 'PSCTTP107') {
		// jb default
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
	} else if (creative_type_cd == 'PSCTTP108') {
		// jb big text
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#sub_text").displayBytes(250, "sub_text_validate");
		$("#summary_text").displayBytes(25, "summary_text_validate");
	} else if (creative_type_cd == 'PSCTTP109') {
		// jb inbox
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#inbox_text_line_1").displayBytes(25, "inbox_text_line_1_validate");
		$("#inbox_text_line_2").displayBytes(25, "inbox_text_line_2_validate");
		$("#inbox_text_line_3").displayBytes(25, "inbox_text_line_3_validate");
		$("#inbox_text_line_4").displayBytes(25, "inbox_text_line_4_validate");
		$("#inbox_text_line_5").displayBytes(25, "inbox_text_line_5_validate");
		$("#inbox_text_line_6").displayBytes(25, "inbox_text_line_6_validate");
		$("#inbox_text_line_7").displayBytes(25, "inbox_text_line_7_validate");
		$("#summary_text").displayBytes(25, "summary_text_validate");
	} else if (creative_type_cd == 'PSCTTP110') {
		// jb big picture
		$("#content_title").displayBytes(25, "content_title_validate");
		$("#content_text").displayBytes(25, "content_text_validate");
		$("#summary_text").displayBytes(25, "summary_text_validate");
	}

	$("#landing_type_url").displayBytes(200, "landing_type_url_validate");
	$("#and_run_url").displayBytes(200, "and_run_url_validate");
	$("#tst_dl_url").displayBytes(200, "tst_dl_url_validate");
	$("#mar_dl_url").displayBytes(200, "mar_dl_url_validate");
	$("#alt_url").displayBytes(200, "alt_url_validate");

	if (creative_type_cd == 'PSCTTP107' || creative_type_cd == 'PSCTTP108'
			|| creative_type_cd == 'PSCTTP109'
			|| creative_type_cd == 'PSCTTP110') {
		// jb
		$("#action1_text").displayBytes(10, "action1_text_validate");
		$("#action1_landing_type_url").displayBytes(200,
				"action1_landing_type_url_validate");
		$("#action1_and_run_url").displayBytes(200,
				"action1_and_run_url_validate");
		$("#action1_tst_dl_url").displayBytes(200,
				"action1_tst_dl_url_validate");
		$("#action1_mar_dl_url").displayBytes(200,
				"action1_mar_dl_url_validate");
		$("#action1_alt_url").displayBytes(200, "action1_alt_url_validate");

		$("#action2_text").displayBytes(10, "action2_text_validate");
		$("#action2_landing_type_url").displayBytes(200,
				"action2_landing_type_url_validate");
		$("#action2_and_run_url").displayBytes(200,
				"action2_and_run_url_validate");
		$("#action2_tst_dl_url").displayBytes(200,
				"action2_tst_dl_url_validate");
		$("#action2_mar_dl_url").displayBytes(200,
				"action2_mar_dl_url_validate");
		$("#action2_alt_url").displayBytes(200, "action2_alt_url_validate");

		$("#action3_text").displayBytes(10, "action3_text_validate");
		$("#action3_landing_type_url").displayBytes(200,
				"action3_landing_type_url_validate");
		$("#action3_and_run_url").displayBytes(200,
				"action3_and_run_url_validate");
		$("#action3_tst_dl_url").displayBytes(200,
				"action3_tst_dl_url_validate");
		$("#action3_mar_dl_url").displayBytes(200,
				"action3_mar_dl_url_validate");
		$("#action3_alt_url").displayBytes(200, "action3_alt_url_validate");
	}
}

function checkFreezing() {
	var freezing = $("#freezing").val();
	var ad_status_cd = $("#ad_status_cd").val();
//	if(freezing != '1' || ad_status_cd == 'PSEADST01') {
//		return;
//	}
	
	if(ad_status_cd == 'PSEADST02') {
		$("#ad_table *").attr("disabled", "disabled");
		$("#target_table *").attr("disabled", "disabled");
//		$("#creative_table *").attr("disabled", "disabled");
//		$("#creative_test_layer *").removeAttr('disabled');
//		$("#edit_btn").hide();
		unselectableTree(true);
	} else if (ad_status_cd == 'PSEADST03' || ad_status_cd == 'PSEADST04') {
		$("#ad_table *").attr("disabled", "disabled");
		$("#target_table *").attr("disabled", "disabled");
		$("#creative_table *").attr("disabled", "disabled");
		$("#creative_test_layer *").removeAttr("disabled");
		$("#edit_btn").hide();
		unselectableTree(true);
	}
}

function unselectableTree(unselectable) {
	$(".dynatree-container").each(function() {
		$("#" + this.parentElement.id).dynatree("getRoot").visit(function(node) {
			node.data.unselectable = unselectable;
		});
		$("#" + this.parentElement.id).addClass('ui-dynatree-disabled');
	});
}

function changeCreative(creative_type_cd) {
	if (typeof (creative_type_cd) == 'undefined') {
		creative_type_cd = $("#creative_type_cd").val();
	}

	checkCreativeJB(creative_type_cd);

	var params = new Object();

	params.creative_type_cd = creative_type_cd;

	$.ajax({
		type : "GET",
		url : "/campaign/advert/creative",
		data : params,
		dataType : "html",
		success : function(result) {
			$("#creative_layer").html(result);
			initLandingType();
			bindCreativeEvent();
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}

function checkCreativeJB(creative_type_cd) {
	if (typeof (creative_type_cd) == 'undefined') {
		creative_type_cd = $("#creative_type_cd").val();
	}

	if (creative_type_cd == 'PSCTTP107' || creative_type_cd == 'PSCTTP108'
			|| creative_type_cd == 'PSCTTP109'
			|| creative_type_cd == 'PSCTTP110') {
		selectCreativeJB(true);
	} else {
		selectCreativeJB(false);
	}
}

function creativePriview() {
	alert('테스트 App에서 제공');
}

function creativeTest() {
	var ad_sq = $("#ad_sq").val();
	window.open('/campaign/advert/pushPopup?ad_sq=' + ad_sq, 'pushPopup',
			'width=500, height=200, left=50, top=50, scrollbars=yes');
}

function uploadImage(id, value) {
	if (value == '') {
		resetInputFile(id);
		return;
	}

	var temp = value.replace(/\\/g, '/').split('/');
	var filename = temp[temp.length - 1];
	if (filename.match(/[^a-zA-Z0-9_\-\.\(\)]/) != null) {
		alert("파일명은 영어와 숫자만 사용할 수 있습니다.");
		resetInputFile(id);
		return;
	}

	removeRules('write_form');
	setBindForm(false);

	var params = new Object();
	params.file_id = id;
	params.creative_type_cd = $("#creative_type_cd").val();

	$('#write_form').ajaxForm({
		dataType : 'json',
		data : params,
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") {
				if (id == 'large_icon_image_file') {
					$("#large_icon_image").val(json.response_data);
					$("#large_icon_image_preview").attr('src', json.response_data);
				} else if (id == 'banner_image_file') {
					$("#banner_image").val(json.response_data);
					$("#banner_image_preview").attr('src', json.response_data);
				} else if (id == 'popup_image_file') {
					$("#popup_image").val(json.response_data);
					$("#popup_image_preview").attr('src', json.response_data);
				}
			} else {
				alert(json.response_data);
				resetInputFile(id);
			}

			initValidateRules();
			setBindForm(true);
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
			resetInputFile(id);

			initValidateRules();
			setBindForm(true);
		}
	});

	$("#write_form").attr('action', '/campaign/advert/image');
	$("#write_form").attr('method', 'POST');
	$("#write_form").attr('enctype', 'multipart/form-data');

	$('#write_form').submit();
}

function selectCreativeJB(isSelect) {
	if (isSelect) {
		$("#target_os_enable option[value=1]").remove();
		$("#target_os_enable option[value=0]").attr("selected", true);
	} else {
		if ($("#target_os_enable option[value=1]").length == 0) {
			var option = new Option('설정', '1');
			if ($.browser.msie) {
				document.getElementById("target_os_enable").add(option);
			} else {
				document.getElementById("target_os_enable").add(option, null);
			}
		}
	}
	
	$("#target_os_enable").change();
}

function advert_edit() {
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

	$("#write_form").attr('action', '/campaign/advert');
	$("#write_form").attr('method', 'PUT');
	$("#write_form").removeAttr('enctype');

	$('#write_form').submit();
}
