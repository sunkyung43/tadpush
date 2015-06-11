function executeAction(){

	if($("input[name=media_group_id]:checked").val() == null){
		alert("미디어 그룹을 선택해 주세요");
		return;
	}
	if($("#action_value").val() == ''){
		alert("실행할 명령을 선택해 주세요");
		return;
	}
	
	if($("#action_value").val() == 'delete'){

		if (!confirm('선택한 항목을 삭제 하시겠습니까?')) {
			return;
		}

		//삭제
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
		
		$("#list_form").attr('action', '/system/target/mediaGroup_delete');
		$("#list_form").attr('method', 'DELETE');
		$('#list_form').submit();
		
	}else{
		//엑셀다운로드
		location.href = '/system/target/mediaGroup_excel?media_group_id=' +$("input[name=media_group_id]:checked").val();
	}
}
