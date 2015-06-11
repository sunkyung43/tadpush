<SCRIPT type="text/javascript">
$(document).ready(function() {

	});


function idCheck() {
	var params = new Object();

	params.USER_ID = $("#USER_ID").val();
	$.ajax({
				type : "GET",
				url : "/test/join/idcheck",
				data : params,
				dataType : 'json',
				success : function(json) {
					if (json.response_type == "success") {
						alert(json.response_data);
					} else {
						alert(json.response_data);
					}
				},
				error : function(data) {
					alert("요청에 실패하였습니다." + data.responseText);
					return;
				}
			});
}

function join(form_id, method, request_url) {
	$.ajax({
		type : method,
		url : request_url,
		data : $("#" + form_id).serialize(),
		dataType : 'json',
		success : function(json) {
			if (json.response_type == "success") {
				// 입력성공
				alert(json.response_data);
			} else {
				// 입력실패
				alert(json.response_data);
			}
		},
		error : function(data) {
			alert("요청에 실패하였습니다." + data.responseText);
			return;
		}
	});
}

</SCRIPT>
<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>T ad Push 계정 등록</h3>
	</div>

	<form id="write_form" name="write_form">
		<table class="boardDataType" summary="광고주 관리">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<tr>
				<th colspan="2" style="text-align: center">POC_ACCOUNT</th>
			</tr>
			<tr>
				<th>ACCOUNT_SQ</th>
				<td class="end">자동생성</td>
			</tr>
			<tr>
				<th>* ACCOUNT_GB</th>
				<td class="end"><input id="ACCOUNT_GB" name="ACCOUNT_GB" value="ADMIN" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>* ACCOUNT_STATUS_CD</th>
				<td class="end"><input id="ACCOUNT_STATUS_CD" name="ACCOUNT_STATUS_CD" value="ACS101" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>* USER_ID</th>
				<td class="end">
					<input id="USER_ID" name="USER_ID" value="" class="textType" title="" type="text" />
					<a href="javascript:idCheck();">ID 조회</a>
				</td>
			</tr>
			<tr>
				<th>* USER_PASSWD</th>
				<td class="end"><input id="USER_PASSWD" name="USER_PASSWD" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th colspan="2" style="text-align: center">POC_ADMIN_USER</th>
			</tr>
			<tr>
				<th>ACCOUNT_SQ</th>
				<td class="end">자동생성</td>
			</tr>
			<tr>
				<th>* ROLE_SQ</th>
				<td class="end"><input id="ROLE_SQ" name="ROLE_SQ" value="200" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>* USER_STATUS_CD</th>
				<td class="end"><input id="USER_STATUS_CD" name="USER_STATUS_CD" value="ACS101" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>USER_NM</th>
				<td class="end"><input id="USER_NM" name="USER_NM" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>COMPANY_NM</th>
				<td class="end"><input id="COMPANY_NM" name="COMPANY_NM" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>TEAM_NM</th>
				<td class="end"><input id="TEAM_NM" name="TEAM_NM" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>DUTY_NM</th>
				<td class="end"><input id="DUTY_NM" name="DUTY_NM" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>MOBILE_NO</th>
				<td class="end"><input id="MOBILE_NO" name="MOBILE_NO" value="" class="textType" title="" type="text" /></td>
			</tr>
			<tr>
				<th>EMAIL</th>
				<td class="end"><input id="EMAIL" name="EMAIL" value="" class="textType" title="" type="text" /></td>
			</tr>
			
			</table>
	</form>

	<div class="btnC clear">
		<a
			href="javascript:join('write_form', 'POST', '/test/join');"><img
			src="/web/images/button/reg.gif" alt="등록" /> </a>
	</div>


</div>
<!-- //content-->
