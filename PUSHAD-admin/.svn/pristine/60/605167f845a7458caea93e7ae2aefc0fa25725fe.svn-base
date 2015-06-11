function initTargetMedia() {
	$(".target_media_radio").change(function() {
		$("#target_media_name_layer").hide();
		$("#target_media_group_layer").hide();
		$("#target_media_category_layer").hide();

		var type = $(this).val();
		$("#target_media_" + type + "_layer").show();
	});

	var target_media_type = $(":radio[name='target_media_type']:checked").val();
	if (typeof (target_media_type) == 'undefined') {
		$(":radio[name='target_media_type'][value='name']").attr("checked",
				"checked");
	}

	$(":radio[name='target_media_type']:checked").trigger("change");

	$("#media_list").selectable();
	$("#selected_media").selectable();

	checkMediaList();

	$('#search_media').live('keypress', function(e) {
		if (e.which == 13) {
			searchMedia();
		}
	});
}

//디바이스/미디어 엑셀 업로드
function uploadExcel(id, value) {
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

	var allowedExt = "\.(xls)$";
	if (filename != '' && filename.match(allowedExt) == null) {
		alert("첨부 파일은 엑셀파일만 가능 합니다.");
		resetInputFile(id);
		return;
	}

	if(typeof removeRules == 'function') {
		removeRules('write_form');
	}
	if(typeof setBindForm == 'function') {
		setBindForm(false);
	}

	var params = new Object();
	params.file_id = id;

	// ajax form submit
	$('#write_form').ajaxForm({
		dataType : 'json',
		data : params,
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") {
				if (id == 'device_template') {
					checkDevice(json.response_data.split(","));
				} else if (id == 'media_template') {
					$("#selected_media").html(json.media_html);
					checkMediaList();
				}
			} else {
				alert(json.response_data);
				resetInputFile(id);
			}
			resetInputFile(id);

			if(typeof initValidateRules == 'function') {
				initValidateRules();
			}
			if(typeof setBindForm == 'function') {
				setBindForm(true);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
			resetInputFile(id);

			if(typeof initValidateRules == 'function') {
				initValidateRules();
			}
			if(typeof setBindForm == 'function') {
				setBindForm(true);
			}
		}
	});

	if (id == 'device_template') {
		$("#write_form").attr('action', '/campaign/advert/deviceTemplete');
	} else if (id == 'media_template') {
		$("#write_form").attr('action', '/campaign/advert/mediaTemplete');
	}
	$("#write_form").attr('method', 'POST');
	$("#write_form").attr('enctype', 'multipart/form-data');

	$('#write_form').submit();
}

function checkDevice(device_array) {
	size = device_array.length;

	var id = '';

	$("#target_device_tree").dynatree("getRoot").visit(function(node) {
		node.select(false);
	});

	for (i = 0; i < size; i++) {
		id = device_array[i];
		$("#target_device_tree").dynatree("getTree").selectKey(id);
	}

}

function addMedia() {
	$("#media_list >.ui-selected").each(function() {
		$(this).removeClass('ui-selected');
		$(this).children().each(function() {
			$(this).removeClass('ui-selected');
		});
		if ($(this).is('td')) {
			return;
		}
		var mediaID = this.id;
		var isSelected = false;
		$("#selected_media > tr").each(function() {
			if (this.id == mediaID) {
				isSelected = true;
			}
		});
		if (!isSelected) {
			$('#selected_media').append(this.outerHTML);
		}
		$(this).remove();
	});

	checkMediaList();
}

function removeMedia() {
	$("#selected_media >.ui-selected").each(function() {
		$(this).removeClass('ui-selected');
		$(this).children().each(function() {
			$(this).removeClass('ui-selected');
		});
		if ($(this).is('td')) {
			return;
		}
		$('#media_list').append(this.outerHTML);
		$(this).remove();
	});

	checkMediaList();
}

function checkMediaList() {
	var selected_media_count = 0;
	var media_id_list = '';
	$("#selected_media > tr").each(function() {
		media_id_list += media_id_list == '' ? this.id : "," + this.id;
		selected_media_count++;
	});
	$("#media_name_cd").val(media_id_list);
	$("#selected_media_count").html(selected_media_count);
}

function searchMedia() {
	var params = new Object();

	params.search_media = $("#search_media").val();

	$.ajax({
		type : "GET",
		url : "/campaign/advert/searchMedia",
		data : params,
		dataType : "json",
		success : function(json) {
			if (json.response_type == "success") {
				$("#media_count").html(json.media_count);
				$("#media_list").html(json.media_html);
			} else {
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}

function changeTarget(target_type, enable) {
	if (typeof (target_type) == 'undefined' || typeof (enable) == 'undefined') {
		return;
	}

	if (enable == "1") {
		$("#target_" + target_type + "_layer").show();
	} else {
		$("#target_" + target_type + "_layer").hide();
	}
}

function getSigugun() {
	var params = new Object();

	params.sido_cd = $("#sido_cd").val();

	$.ajax({
		type : "GET",
		url : "/campaign/advert/sigugunSelectbox",
		data : params,
		dataType : "html",
		success : function(result) {
			$("#sigugun_selectbox").html(result);
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
		}
	});
}

function addRegionCode() {
	if ($('#region_code_selected > option').size() >= 10) {
		alert("타겟팅 지역 설정을 10개 넘게 설정 할 수 없습니다.");
		return;
	}

	sido_value = $("#sido_cd option:selected").val();
	sigugun_value = $("#sigugun_cd option:selected").val();
	sido_text = $("#sido_cd option:selected").text();
	sigugun_text = $("#sigugun_cd option:selected").text();
	var option;
	var region_value = '';
	var region_flag = false;
	if (sigugun_value != '') {
		option = new Option(sido_text + " " + sigugun_text, sigugun_value);
		region_value = sigugun_value;
	} else if (sido_value != '') {
		option = new Option(sido_text, sido_value);
		region_value = sido_value;
	}

	var temp_sigugun_value = '';
	$('#region_code_selected > option').each(function(i, element) {
		temp_sigugun_value = $(element).val();
		if (region_value == temp_sigugun_value) {
			region_flag = true;
			return false;
		}
		
		if(sigugun_value != '') {
			if(sigugun_value.indexOf(temp_sigugun_value) == 0) {
				region_flag = true;
				return false;
			}
		} else {
			if(temp_sigugun_value.indexOf(sido_value) == 0) {
				$(element).remove();
			}
		}
	});

	if (!region_flag) {
		if ($.browser.msie) {
			document.getElementById("region_code_selected").add(option);
		} else {
			document.getElementById("region_code_selected").add(option, null);
		}
	}

	checkRegionCode();
}

// 선택된 지역을 삭제한다.
function removeRegionCode() {
	$("#region_code_selected option:selected").remove();

	checkRegionCode();
}

function checkRegionCode() {
	var region_sido_list = '';
	var region_gugun_list = '';
	var region_cnt = $('#region_code_selected > option').size();
	for ( var i = 0; i < region_cnt; i++) {
		region_code = $('#region_code_selected > option')[i].value;
		if (region_code.length == 2) {
			region_sido_list += region_sido_list == '' ? region_code : ','
					+ region_code;
		} else {
			region_gugun_list += region_gugun_list == '' ? region_code : ','
					+ region_code;
		}
	}
	$("#region_sido_cd").val(region_sido_list);
	$("#region_gugun_cd").val(region_gugun_list);
}
