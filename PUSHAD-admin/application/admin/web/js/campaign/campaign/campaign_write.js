$(document).ready(function() {
	initValidate();

	$("#campaign_nm").displayBytes(80, 'campaign_nm_validate');
	$("#campaign_desc").displayBytes(200, 'campaign_desc_validate');

	initAutoComplete();
	
	$('#campaign_nm').focus();
});

function initValidate() {
	$("#write_form").validate({
		ignore : "input[type='text']:hidden",
		rules : {
			"campaign_nm" : {
				required : true
			},
			"adv_company_sq" : {
				required : true
			},
			"adv_company_nm" : {
				required : true
			},
			"adv_account_sq" : {
				required : true
			},
			"report_password" : {
				required : true
			}
		},
		messages : {
			campaign_nm : "캠페인 명",
			adv_company_sq : "광고주",
			adv_company_nm : "광고주",
			adv_account_sq : "브랜드",
			report_password : "Report PW"
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
			if (!confirm('등록 하시겠습니까?')) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
		}
	});
}

function initAutoComplete() {
	$("#adv_company_nm").autocomplete({
		source : function(request, response) {
			$('#adv_company_sq').val('');
			$.ajax({
				url : "/campaign/campaign/company",
				dataType : "jsonp",
				data : {
					featureClass : "P",
					style : "full",
					maxRows : 10,
					adv_company_nm : request.term
				},
				success : function(data) {
					response($.map(data.items, function(item) {
						return {
							label : item.adv_company_nm,
							value : item.adv_company_nm,
							adv_company_sq : item.adv_company_sq,
							adv_company_nm : item.adv_company_nm
						}
					}));
				}
			});
		},
		minLength : 2,
		select : function(event, ui) {
			$('#adv_company_sq').val(ui.item.adv_company_sq);

			// 브랜드명을 가져온다.
			$.ajax({
				type : "GET",
				url : "/campaign/campaign/brand",
				data : {
					'adv_company_sq' : ui.item.adv_company_sq
				},
				dataType : 'json',
				success : function(json) {
					if (json.response_type == "success") {
//						$("#brand_selectbox_layer").html(json.response_data);
						$('#adv_account_sq option').remove();
						$("<option value=''>선택해주세요</option>").appendTo('#adv_account_sq');
						for (var i in json.response_data)
						{
							$("<option value='" + json.response_data[i]['adv_account_sq'] + "'>" + json.response_data[i]['adv_brand_nm'] + "</option>").appendTo('#adv_account_sq');
						}
					} else {
						alert(json.response_data);
					}
				},
				error : function(data) {
					alert("요청에 실패하였습니다." + data.responseText);
				}
			});
		},
		open : function() {
			$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
		},
		close : function() {
			$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
		}
	});
}

function campaign_write() {
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

	$("#write_form").attr('action', '/campaign/campaign');
	$("#write_form").attr('method', 'POST');

	$('#write_form').submit();
}

function campaign_cancel() {
	if (confirm('등록 중이던 모든 정보가 삭제 됩니다. 취소 하시겠습니까?')) {
		location.replace('/campaign/campaign');
	}
}
