function executeAction() {
	var popup = $("#actionType").val();
	var selectValue = $("input[name=select_media_id]:checked").val();
	if(selectValue == ""){
		alert("미디어를 선택해주세요.")	
		return;
	}
	if(popup== "Y"){
		
		window.open('/media/media/detail?popupYN=Y&type=detail&media_id=' + selectValue, 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');
	}
}

function search() {
	var params = $("#list_form").serialize();
location.replace('/report/pcpMediaReport?' + params);
}