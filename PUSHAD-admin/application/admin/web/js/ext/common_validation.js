jQuery.extend(jQuery.validator.messages, {
    required: "필수항목입니다.",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "유효하지 않은 URL입니다.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "숫자만 입력하세요.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}."),
    maxbytes: jQuery.validator.format("{0} Byte를 초과하였습니다.")
});

jQuery.validator.addMethod("maxbytes", function(value, element, param) {
    return this.optional(element) || (getBytes(value) <= param);
});

function removeRules(form_id) {
	var settings = $("#" + form_id).validate().settings;
	for (var id in settings.rules){
		if($("#" + id).length > 0) {
			$("#" + id).rules("remove");
		}
	}
}

function getBytes(value) {
	var str_len = value.length;
	var cbyte = 0;

	for (i = 0; i < str_len; i++) {
		var ls_one_char = value.charAt(i);
		if (escape(ls_one_char).length > 4) {
			cbyte += 2; // 한글이면 2를 더한다
		} else {
			cbyte++; // 한글아니면 1을 다한다
		}
	}

	return parseInt(cbyte)
}