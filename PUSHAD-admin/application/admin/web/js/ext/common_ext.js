//FF formdata reset용
$(document).ready(function () {
    var allInputs = $(":input");
    $(allInputs).attr('autocomplete', 'off');
});

function downloadDeviceExcelTemplete() {
	location.replace('/campaign/advert/deviceTemplete');
}

function downloadMediaExcelTemplete() {
	location.replace('/campaign/advert/mediaTemplete');
}

function isValidUrl(url) {
	if(typeof(url) == 'undefined' || url == '') {
		return false;
	}
	
	var urlRule = /^(http|https|market|itms):\/\//;
	if(!urlRule.test(url)) {
		return false;
	}
	
	return true;
}

function resetInputFile(id) {
	if (typeof (id) == 'undefined') {
		return;
	}

	if (id.charAt(0) != '#') {
		id = '#' + id;
	}

	if ($.browser.msie) {
//		$(id).replaceWith($(id).clone(true));
	} else {
		$(id).val("");
	}

}

// control change check
/**
 * @example survey('input[name=searchStartDate]', function(){ alert("까꿍"); });
 */
function survey(selector, callback) {
	var input = $(selector);
	var oldvalue = input.val();
	setInterval(function() {
		if (input.val() != oldvalue) {
			oldvalue = input.val();
			callback();
		}
	}, 100);
};

jQuery.fn.displayBytes = function(maxLength, displayID) {
	this.each(function() {
		$(this).keydown(function(e) {
			if(e.keyCode == 8 ||
					e.keyCode == 46 ||
					e.keyCode == 17 ||
					e.keyCode == 27 ||
					(e.keyCode >= 122 && e.keyCode <= 123) ||
					(e.keyCode >= 37 && e.keyCode <= 40)) {
				return;	
			}

			var str_len = $(this).val().length;
			var cbyte = 0;
			var li_len = 0;

			for (i = 0; i < str_len; i++) {
				var ls_one_char = $(this).val().charAt(i);
				if (escape(ls_one_char).length > 4) {
					cbyte += 1; // 한글이면 2를 더한다
				} else {
					cbyte++; // 한글아니면 1을 다한다
				}
				if (cbyte <= maxLength) {
					li_len = i + 1;
				}
			}

			var ls_one_char = String.fromCharCode(e.keyCode);
			if (ls_one_char != '') {
				if (escape(ls_one_char).length > 4 || e.keyCode == 229) {
					cbyte += 1; // 한글이면 2를 더한다
				} else {
					cbyte++; // 한글아니면 1을 다한다
				}
				if (cbyte <= maxLength) {
					li_len = i + 1;
				}
			}

			// 사용자가 입력한 값이 제한 값을 초과하는지를 검사한다.
			if (parseInt(cbyte) > parseInt(maxLength)) {
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
			}
		});
		$(this).keyup(function(e) {
			var str_len = $(this).val().length;
			var cbyte = 0;
			var li_len = 0;

			for (i = 0; i < str_len; i++) {
				var ls_one_char = $(this).val().charAt(i);
				if (escape(ls_one_char).length > 4) {
					cbyte += 1; // 한글이면 2를 더한다
				} else {
					cbyte++; // 한글아니면 1을 다한다
				}
				if (cbyte <= maxLength) {
					li_len = i + 1;
				}
			}

			// 사용자가 입력한 값이 제한 값을 초과하는지를 검사한다.
			if (parseInt(cbyte) > parseInt(maxLength)) {
				 $(this).val($(this).val().substr(0, li_len));
				cbyte = parseInt(maxLength);
			}
			
			if (typeof (displayID) != 'undefined') {
				if (displayID.charAt(0) != '#') {
					displayID = '#' + displayID;
				}
				
				if($(displayID).length == 0) {
					$('<span>').attr({
					    id: displayID.replace('#', '')
					}).insertAfter("#" + this.id);
				}
				
				var html = '';
//				if (parseInt(cbyte) > parseInt(maxLength)) {
//					html += '<label class="maxbytes-error">';
//				} else {
//					html += '<label>';
//				}

				html += '<strong class="counting"> ';
				html += cbyte;
				html += '</strong>';
				html += ' / ';
				html += maxLength;
				html += '자';
				
//				html += '</label>';
	
				$(displayID).html(html);
			}

		});
	});
	
	this.keyup();
};

// Numeric only control handler
jQuery.fn.ForceNumericOnly = function(maxNumber, disable_comma, enableZero) {
	return this.each(function() {
		$(this).keydown(
				function(e) {
					// Allow: backspace, delete, tab,
					// escape, and enter
					if (e.keyCode == 46 || e.keyCode == 8 || e.keyCode == 9
							|| e.keyCode == 27 || e.keyCode == 13 ||
							// Allow: Ctrl+A
							(e.keyCode == 65 && e.ctrlKey === true) ||
							// Allow: home, end, left, right
							(e.keyCode >= 35 && e.keyCode <= 39)) {
						// let it happen, don't do
						// anything
						return;
					} else {
						// Ensure that it is a number and stop
						// the keypress
						if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault ? e.preventDefault() : e.returnValue = false;
							return;
						}
					}

					if (typeof (maxNumber) != 'undefined') {
						var newNumber = e.keyCode - 48;
						if(newNumber > 9) {
							newNumber = newNumber - 48;
						}
						if(newNumber < 0 || newNumber > 9) {
							return;
						}
						var curNumber = $(this).val() + "" + newNumber;
						curNumber = curNumber.replace(",", "");

						if (curNumber > maxNumber) {
							e.preventDefault ? e.preventDefault() : e.returnValue = false;
							return;
						}
					}
					
					if (typeof (enableZero) == 'undefined' || !enableZero) {
						if ((e.keyCode == 48 || e.keyCode == 96)
								&& $(this).val() == '') {
							e.preventDefault ? e.preventDefault()
									: e.returnValue = false;
						}
					}
				});

		if (typeof (disable_comma) == 'undefined' || !disable_comma) {
			$(this).focusout(
					function() {
						$(this).val(
								$(this).val().replace(
										/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
					});
		}

		$(this).focusin(function() {
			$(this).val($(this).val().replace(/\,/g, ''));
		});
	})
};

// checkAll : #id 또는 html object (ex : this)
// targetCheckbox : checked 를 변경할 checkbox의 name
// option : 미선언시 disabled 가 아닌것만, 선언시 disabled 포함 전체
function checkAllCheckbox(checkAll, targetCheckbox, option) {
	option = (typeof (option) == 'undefined') ? ':enabled' : '';
	$("input[name='" + targetCheckbox + "']" + option).attr("checked",
			$(checkAll).is(':checked'));
}

// 화면중앙에 새창띄우기 함수
function new_window(url, name, option, w, h, left, top) {
	var winH = window.screen.height;
	var winW = window.screen.width;
	var nWinH = h;
	var nWinW = w;
	if (!left)
		left = (winW - nWinW) / 2;
	if (!top)
		top = (winH - nWinH) / 2 - 50;
	if (!option)
		option = "resizable=no,scrollbars=no,menubar=no,status=0";
	return window.open(url, name, option + ", width=" + nWinW + ", height="
			+ nWinH + ", top=" + top + ", left=" + left)
}

// 두 날자의 차이 (날자수) 를 구한다. ex) 2012-12-01, 2012-12-02 => 2
function dateDiff(date1, date2) {
	var d1 = new Date(date1);
	var d2 = new Date(date2);
	return parseInt((d2.getTime() - d1.getTime()) / (24 * 3600 * 1000), 10) + 1;
}

function request(form_id, method, request_url) {
	$.ajax({
		type : method,
		url : request_url,
		data : $("#" + form_id).serialize(),
		dataType : 'json',
		success : function(json) {
			if (json.response_type == "success") {
				// 입력성공
				location.replace(json.response_data);
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

function confirm_and_request(message, form_id, method, request_url) {
	if (confirm(message)) {
		request(form_id, method, request_url);
	}
}

function cancel(target_url) {
	location.replace(target_url);
}

function confirm_and_replace(message, target_url) {
	if (confirm(message)) {
		cancel(target_url);
	}
}

function fn_onlyNumber(loc) {
	if (/[^0123456789]/g.test(loc.value)) {
		alert("숫자만 입력해 주세요!");
		// loc.value = "";
		loc.focus();
	}
}
