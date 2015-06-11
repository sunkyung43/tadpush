function search() {
	$("#list_form").submit();
}

function executeAction(){
	var type = $("#actionType").val();
	var selectValue = $("input[name=select_media_id]:checked").val();
	if(selectValue == ""){
		alert("미디어를 선택해주세요.")	
		return;
	}
	if(type== "popup"){
		
		window.open('/report/pcpMediaReport/detail?type=popup&media_id=' + selectValue, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
	}
	if(type== "delete"){
		if (confirm("미디어를 삭제합니다.")) {
			executeDelete();
		}
	}
}

function executeDelete(selectValue) {
	$('#list_form').ajaxForm({
		dataType : 'json',
		data : $("#list_form").serialize(),
		success : function(json, statusText, xhr, $form) {
			if (json.response_type == "success") 
			{
				alert('삭제 하였습니다.')
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
	
	$("#list_form").attr('action', '/media/media');
	$("#list_form").attr('method', 'PUT');
	$('#list_form').submit();
}
