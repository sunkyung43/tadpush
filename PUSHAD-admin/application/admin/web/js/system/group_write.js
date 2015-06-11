$(document).ready(function() {

	$("#media_group_desc").displayBytes(200, "desc_validate");
	$("#media_group_desc").keyup();
	
	$("#media_list").selectable();
	$("#selected_media").selectable();
	checkMediaList();

	$('#write_form').bind('submit',function(e){
			if (!confirm('등록(수정) 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
	});
});

function initValidate() {
	$("#write_form").validate({
		rules : {
			"group_id" : {
				required : true
			},
			"media_group_desc" : {
				required : true
			},
			"start_dt" : {
				required : true
			},
			"start_time" : {
				required : true
			}
		},
		errorPlacement : function(error, element) {

		},
		invalidHandler : function(form, validator) {
			alert('필수 입력 사항을 입력해주세요.');
			validator.focusInvalid();
		}
	});

	$('#write_form').bind('submit', function(e) {
		if ($(".error").length == 0) {
			if ($("#creative_filename").val() == '') {
				alert('필수 입력 사항을 입력해주세요.');
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
				return;
			}

			if (!confirm('수정 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
		}
	});

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

function executeSave() {
	if($("#media_group_id").val() == ""){
		alert("그룹을 선택해 주세요.")	
		return;
	}
	if($("#media_group_desc").val() == ""){
		alert("그룹설명을 입력해 주세요.")	
		return;
	}
	if($("#media_name_cd").val() == ""){
		alert("미디어를 추가해 주세요.")	
		return;
	}
	
	$('#write_form').ajaxForm({
		dataType : 'json',
		data : $("#write_form").serialize(),
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") 
			{
				alert('등록(수정) 하였습니다.')
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
	
	$("#write_form").attr('action', '/system/target/mediaGroup_write');
	$("#write_form").attr('method', 'POST');
	$('#write_form').submit();
}

function content_cancel() {
	if (confirm('등록 중이던 모든 정보가 삭제 됩니다. 취소 하시겠습니까?')) {
		location.replace('/system/target/');
	}
}