<script type="text/javascript">
<!--
$(document).ready(function() {
	initValidate();
});

function initValidate() {
	$("#write_form").validate({
		ignore : "input[type='text']:hidden",
		rules : {
			"provision_ver" : {
				required : true
			},
			"person_offer_content" : {
				required : true
			},
			"person_gather_content" : {
				required : true
			},
			"location_cather_content" : {
				required : true
			},
			"ad_receive_content" : {
				required : true
			},
			"policy_content" : {
				required : true
			}
		},
		messages : {
			provision_ver : "약관 Ver.",
			person_offer_content : "개인정보 제공 동의",
			person_gather_content : "개인정보 수집/이용 동의",
			loction_cather_content : "약관 및 개인위치정보 수집/이용",
			ad_receive_content : "정보/광고 수신동의",
			policy_content : "개인정보 취급방침"
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

function provision_write() {
	var params = new Object();
	$.get('/system/provisionSupervise/exist_ver', {'provision_ver' : $("#provision_ver").val()}, function(data){
		if(data.response_type == "false")	{
			alert(data.response_data);
			return;
		}else{
			$('#write_form').ajaxForm({
				dataType : 'json',
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

			$("#write_form").attr('action', '/system/provisionSupervise/write');
			$("#write_form").attr('method', 'POST');

			$('#write_form').submit();
		}
	});
}

function provision_cancel() {
	if (confirm('등록 중이던 모든 정보가 삭제 됩니다. 취소 하시겠습니까?')) {
		location.replace('/system/provisionSupervise');
	}
}
//-->
</script>
<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>약관 관리</h3>
	</div>

<!-- 검색 //-->
<!-- <div class="searchArea">
	<div class="n_search">
		<strong class="title">MDN 입력</strong> <input type="text"
			id="searchValue" name="searchValue" class="textType mg_l10"
			title="검색어 입력" value="" /> <a href="javascript:mdn_search();"><img
			id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" /> </a>
	</div>
</div> -->
<!--// 검색 -->

<h4>약관 관리(등록)</h4>
<form id="write_form" name="write_form">
	<table class="boardDataType" summary="약관 관리">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th>약관 Ver. 입력</th>
		<td class="end"><input id="provision_ver" name="provision_ver" class="textType" title="" type="text" value=""/><span class="td_notice">※숫자로 입력해주세요.</span></td>
	</tr>
	<tr>
		<th class="textCenter"><strong>동의 목록</strong></th>
		<th class="end textCenter"><strong>내용</strong></th>
	</tr>
	<tr>
		<th>개인정보 제공동의</th>
		<td class="end"><!-- PERSON_OFFER_CONTENT -->
			<textarea id="person_offer_content" name="person_offer_content" rows="5" cols="10" style="width:100%; resize:none;"></textarea>
		</td>
	</tr>
	<tr>
		<th>개인정보 수집/이용 동의</th>
		<td class="end"><!-- PERSON_GATHER_CONTENT -->
			<textarea id="person_gather_content" name="person_gather_content" rows="5" cols="10" style="width:100%; resize:none;"></textarea>
		</td>
	</tr>
	<tr>
		<th>약관 및 개인위치정보 수집/이용</th>
		<td class="end"><!-- LOCATION_CATHER_CONTENT -->
			<textarea id="location_cather_content" name="location_cather_content" rows="5" cols="10" style="width:100%; resize:none;"></textarea>
		</td>
	</tr>
	<tr>
		<th>정보/광고 수신동의</th>
		<td class="end"><!-- AD_RECEIVE_CONTENT -->
			<textarea id="ad_receive_content" name="ad_receive_content" rows="5" cols="10" style="width:100%; resize:none;"></textarea>
		</td>
	</tr>
	<tr>
		<th>개인정보 취급방침</th>
		<td class="end"><!-- POLICY_CONTENT -->
			<textarea id="policy_content" name="policy_content" rows="5" cols="10" style="width:100%; resize:none;"></textarea>
		</td>
	</tr>
	</table>
</form>
	<div class="btnC clear">
		<a href="javascript:provision_write();"><img src="/web/images/button/reg.gif" alt="등록" /></a>
		<a href="javascript:provision_cancel();"><img src="/web/images/button/cancel03.gif" alt="취소" /></a>
	</div>
</div>
<!-- //content-->