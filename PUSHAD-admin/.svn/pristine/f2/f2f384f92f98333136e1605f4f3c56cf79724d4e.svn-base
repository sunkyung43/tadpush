$(document).ready(function() {
	$("#media_nm").displayBytes(30, "media_nm_count");
	$("#media_nm").keyup();

	$("#media_desc").displayBytes(100, "media_desc_count");
	$("#media_desc").keyup();

	$('#write_form').bind('submit',function(e){
			if (!confirm('등록(수정) 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
	});

	var checkIds="";
	$("input[type=checkbox]:checked").each(function() {
		checkIds += checkIds == '' ? this.value : "," + this.value;
	});
	$("#before_group_ids").val(checkIds);
	
});

function clipboard(text, type){
	window.clipboardData.setData('Text', text);
	alert("클립보드에 " + type + "가 복사되었습니다.");
}


function change_history()
{
	window.open('/campaign/advert/pushPopup?ad_sq=' + ad_sq, 'historyPopup', 'width=500, height=200, left=50, top=50, scrollbars=yes');
}

function executeSave() {
	if($("#media_nm").val() == ""){
		alert("미디어 명을 입력해주세요.")	
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
	
	$("#write_form").attr('action', '/media/media/write');
	$("#write_form").attr('method', 'POST');
	$('#write_form').submit();
}

function executeUpdate() {

	var checkIds="";
	$("input[type=checkbox]:checked").each(function() {
		checkIds += checkIds == '' ? this.value : "," + this.value;
	});
	$("#after_group_ids").val(checkIds);

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
	
	$("#write_form").attr('action', '/media/media/write');
	$("#write_form").attr('method', 'PUT');
	$('#write_form').submit();
}

function openPopup(mediaId)
{
	window.open('/media/media/history?media_id=' + mediaId, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
}
