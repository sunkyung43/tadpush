$(document).ready(function(){
	initCalendarBtn();
});

function initCalendarBtn() {
	$(".calendar_btn").click(function(event) {
		var selected_text = $(this).children().html()
		$(".calendar_btn").each(function() {
			if (selected_text == $(this).children().html()) {
				$(this).removeClass('btn_gray03');
				$(this).addClass('btn_blue01');
			} else {
				$(this).removeClass('btn_blue01');
				$(this).addClass('btn_gray03');
			}
		});
	});
}

function create_single_calendar(id, max_week, min_day) {
	if (typeof (id) == 'undefined') {
		return;
	}

	if (id.charAt(0) != '#') {
		id = '#' + id;
	}

	$(id).attr('readonly', true);

	$(id).datepicker({
		changeYear : true,
		changeMonth : true,
		dateFormat : 'yy-mm-dd',
		showMonthAfterYear : true,
		showOn : 'button',
		buttonImageOnly : true,
		buttonImage : '/web/images/common/icon_calendar.gif',
		buttonText : 'calendar',
		firstDay: 1
	});
	
	$(id).datepicker("option", 'monthNamesShort', ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"]);

	var date = new Date();
	var day_index = date.getDay();

	if (typeof (min_day) != 'undefined') {
		$(id).datepicker("option", 'minDate', '+' + min_day + 'd');
	}

	if (typeof (max_week) != 'undefined') {
		var max_day = 0;
		if (max_week > 0) {
			max_day = max_week * 7 + (7 - day_index);
		}
		$(id).datepicker("option", 'maxDate', '+' + max_day + 'd');
	}

	$("img.ui-datepicker-trigger").attr("style", "cursor: pointer;");

}

/**
 * 달력 설정 해당 객체에 아이디값은 필수 입력 cal1, cal2에는 속성을 지정(id, name, class, ...) 두개다 지정할 경우
 * between 속성을 가짐 하나만 지정할 경우 개별로 적용
 */
function create_dual_calendar(start_cal, end_cal) {
	if (typeof (start_cal) == 'undefined' || typeof (end_cal) == 'undefined') {
		return;
	}

	if (start_cal.charAt(0) != '#') {
		start_cal = '#' + start_cal;
	}

	if (end_cal.charAt(0) != '#') {
		end_cal = '#' + end_cal;
	}

	$(start_cal).attr('readonly', true);
	$(end_cal).attr('readonly', true);

	create_calendar(start_cal, end_cal, 'minDate');
	create_calendar(end_cal, start_cal, 'maxDate');

	$(end_cal).datepicker("option", 'minDate', $(start_cal).val());
	$(start_cal).datepicker("option", 'maxDate', $(end_cal).val());

	$("img.ui-datepicker-trigger").attr("style", "cursor: pointer;");
}

function create_calendar(cal1, cal2, option) {
	$(cal1).datepicker({
		changeYear : true,
		changeMonth : true,
		dateFormat : 'yy-mm-dd',
		showMonthAfterYear : true,
		showOn : 'button',
		buttonImageOnly : true,
		buttonImage : '/web/images/common/icon_calendar.gif',
		buttonText : 'calendar',
		firstDay: 1
	});
	
	$(cal1).datepicker("option", 'monthNamesShort', ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"]);

	$(cal1).change(function() {
		$(cal2).datepicker("option", option, $(cal1).val());
		$("img.ui-datepicker-trigger").attr("style", "cursor: pointer;");
		$(cal1).keyup(); // jquery validation event call.
	});
}

function create_frequency_calendar(id, min_day) {
	if (typeof (id) == 'undefined') {
		return;
	}

	if (id.charAt(0) != '#') {
		id = '#' + id;
	}

	$(id).attr('readonly', true);

	$(id).datepicker({
		changeYear : true,
		changeMonth : true,
		dateFormat : 'yy-mm-dd',
		showMonthAfterYear : true,
		showOn : 'button',
		buttonImageOnly : true,
		buttonImage : '/web/images/common/icon_calendar.gif',
		buttonText : 'calendar',
		firstDay: 1
	});
	
	$(id).datepicker("option", 'monthNamesShort', ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"]);

	var date = new Date();
	var day_index = date.getDay();

	if (typeof (min_day) != 'undefined') {
		$(id).datepicker("option", 'minDate', '+' + min_day + 'd');
	}

	$(id).datepicker("option", 'beforeShowDay', function onlyMonday(date) {
		return [ date.getDay() == 1, '' ];
	});

	$("img.ui-datepicker-trigger").attr("style", "cursor: pointer;");

}

/**
 * Left 빈자리 만큼 padStr 을 붙인다
 */
function lpad(src, len, padStr) {
	var retStr = "";
	var padCnt = Number(len) - String(src).length;
	for ( var i = 0; i < padCnt; i++)
		retStr += String(padStr);
	return retStr + src;
}

function minusMonth(yyyymm, term) {
	var yyyy = yyyymm.substring(0, 4);
	var mm = yyyymm.substring(4, 6);

	for (i = 0; i < term; i++) {
		--mm;
		if (mm < 1) {
			mm = 12;
			--yyyy;
		}
	}

	return lpad(yyyy, 4, '0') + lpad(mm, 2, '0');

}

/**
 * 유효한(존재하는) 일(日)인지 체크
 */
function isValidDay(yyyy, mm, dd) {
	var m = parseInt(mm, 10) - 1;
	var d = parseInt(dd, 10);

	var end = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if ((yyyy % 4 === 0 && yyyy % 100 !== 0) || yyyy % 400 === 0) {
		end[1] = 29;
	}

	return (d >= 1 && d <= end[m]);
}

// 월의 끝 일자 얻기
function getEndDate(datestr) {

	// 널인지?
	if (isEmpty(datestr)) {
		return null;
	}

	// 숫자인지?
	if (!isNum(datestr)) {
		return null;
	}

	// 길이가 8자리?
	if (datestr.length != 6) {
		return null;
	}

	var yy = Number(datestr.substring(0, 4));
	var mm = Number(datestr.substring(4, 6));

	// 윤년 검증
	var boundDay = "";

	if (mm != 2) {
		var mon = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		boundDay = mon[mm - 1];
	} else {
		if (yy % 4 == 0 && yy % 100 != 0 || yy % 400 == 0) {
			boundDay = 29;
		} else {
			boundDay = 28;
		}
	}

	return boundDay;
}

/**
 * 입력값에 스페이스 이외의 의미있는 값이 있는지 체크 ex) if (isEmpty(form.keyword)) { alert("검색조건을
 * 입력하세요."); }
 */
function isEmpty(input) {
	if (input === null || input === "")
		return true;
	try {
		if (input.value === null || input.value.replace(/ /gi, "") === "")
			return true;
	} catch (ignore) {
	}
	return false;
}

/**
 * 숫자검증
 */
function isNum(str) {
	if (isEmpty(str))
		return false;
	return isNumber(str);
}

/**
 * 입력값이 숫자로 되어있는지 체크
 */
function isNumber(input) {
	var format = /([^0-9]+)/; // ^ (반대의 의미) 반드시 필요

	if (typeof input === "string") {
		if (input.search(format) === -1)
			return true;
	} else {
		try {
			if (input.value.search(format) === -1)
				return true;
		} catch (e) {
		}
	}

	return false;
}

function getBeforeDate(endDateID, dis) {

	var gv_Data_Gubn = '-';

	var AddDays = 0;
	if (dis == "1W") // 1주일
		AddDays = -7;
	else if (dis == "1M") // 1개월
		AddDays = 'B1';
	else if (dis == "3M") // 3개월
		AddDays = 'B3';
	else if (dis == "6M") // 6개월
		AddDays = 'B6';
	else if (dis == "1Y") // 1년
		AddDays = 'B12';

	var aDate = $(endDateID).val();
	var yy = aDate.substring(0, 4);
	var mm = parseInt(aDate.substring(5, 7), 10) - 1;
	var dd = aDate.substring(8, 10);
	var TDate = new Date(yy, mm, dd);
	var strDate = AddDays.toString();

	TDay = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
	TMonth = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09',
			'10', '11', '12');
	MonthDays = new Array('31', '28', '31', '30', '31', '30', '31', '31', '30',
			'31', '30', '31');

	var loopFlag = 0;

	// 기준날짜가 없을 경우에는 리턴
	if (aDate === null || aDate.length === 0)
		return "";

	CurYear = TDate.getFullYear();

	if (CurYear < 2000) // Y2K Fix
		CurYear = CurYear + 1900;
	CurMonth = TDate.getMonth(); // 월
	CurDayOw = TDate.getDay(); // 요일
	CurDay = TDate.getDate(); // 일
	month = TMonth[CurMonth];

	if (month === '02') {
		if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
				|| ((CurYear % 400) == 0)) {
			MonthDays[1] = 29;
		} else {
			MonthDays[1] = 28;
		}
	}

	days = MonthDays[CurMonth];
	tCurDay = parseInt(CurDay);

	var icount = parseInt(strDate.substring(1));
	var intAddDays = 0;
	var i = 0;

	// 해당 달에 해당하는 총일수를 구하고 증가와 감소할 값을 세팅
	if (strDate.charAt(0) === "A") {
		var mainDate = new Date();
		var returndate;
		mainDate.setFullYear($(endDateID).val().substring(0, 4));
		mainDate.setMonth($(endDateID).val().substring(5, 7) - 1);
		mainDate.setDate($(endDateID).val().substring(8));
		var term = AddDays.substring(1);
		var yyyymm = plusMonth((lpad(mainDate.getFullYear(), 4, '0') + lpad(
				(mainDate.getMonth() + 1), 2, '0')), term);

		if (!isValidDay(yyyymm.substring(0, 4), yyyymm.substring(4), lpad(
				mainDate.getDate(), 2, '0'))) {
			returndate = yyyymm + lpad(getEndDate(yyyymm), 2, '0');
		} else {
			returndate = yyyymm + lpad(mainDate.getDate(), 2, '0');
		}

		returndate = returndate.substring(0, 4) + gv_Data_Gubn
				+ returndate.substring(4, 6) + gv_Data_Gubn
				+ returndate.substring(6, 8);
		return returndate;

	} else if (strDate.charAt(0) === "B") {
		var mainDate = new Date();
		var returndate;
		mainDate.setFullYear($(endDateID).val().substring(0, 4));
		mainDate.setMonth($(endDateID).val().substring(5, 7) - 1);
		mainDate.setDate($(endDateID).val().substring(8));
		var term = AddDays.substring(1);
		var yyyymm = minusMonth((lpad(mainDate.getFullYear(), 4, '0') + lpad(
				(mainDate.getMonth() + 1), 2, '0')), term);

		if (!isValidDay(yyyymm.substring(0, 4), yyyymm.substring(4), lpad(
				mainDate.getDate(), 2, '0'))) {
			returndate = yyyymm + lpad(getEndDate(yyyymm), 2, '0');
		} else {
			returndate = yyyymm + lpad(mainDate.getDate(), 2, '0');
		}

		returndate = returndate.substring(0, 4) + gv_Data_Gubn
				+ returndate.substring(4, 6) + gv_Data_Gubn
				+ returndate.substring(6, 8);
		return returndate;
	}

	CurDay = parseInt(CurDay) + parseInt(AddDays);

	if (AddDays >= 0) { // 0이상이면 날짜를 증가
		// 날짜증가
		while (CurDay > days) {
			if (CurDay > days) {
				if (CurMonth === 11) {
					CurMonth = 0;
					month = TMonth[CurMonth];
					CurYear = CurYear + 1;
					// 윤년 검사
					if (month === '02') {
						if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
								|| ((CurYear % 400) == 0)) {
							MonthDays[1] = 29;
						} else {
							MonthDays[1] = 28;
						}
					}
				} else {
					month = TMonth[CurMonth + 1];
					CurMonth = CurMonth + 1;

					if (month === '02') {
						if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
								|| ((CurYear % 400) == 0)) {
							MonthDays[1] = 29;
						} else {
							MonthDays[1] = 28;
						}
					}
				}
				CurDay = CurDay - days;
				days = MonthDays[CurMonth];
			}
		}
	} else { // 0미만이면 날짜를 감소시킨다.
		// 날자감소
		while (CurDay < 0) {
			if (CurMonth === 0) {
				CurMonth = 11;
				CurYear = CurYear - 1;
				month = TMonth[CurMonth];
				// 윤년 검사
				if (month === '02' && loopFlag == 0) {
					if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
							|| ((CurYear % 400) == 0)) {
						MonthDays[1] = 29;
					} else {
						MonthDays[1] = 28;
					}
					loopFlag = 1;
				}
			} else {
				CurMonth = CurMonth - 1;
				month = TMonth[CurMonth];

				// 윤년 검사
				if (month === '02' && loopFlag == 0) {
					if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
							|| ((CurYear % 400) == 0)) {
						MonthDays[1] = 29;
					} else {
						MonthDays[1] = 28;
					}
					loopFlag = 1;
				}
			}

			month = TMonth[CurMonth];
			days = MonthDays[CurMonth];
			CurDay = parseInt(CurDay) + parseInt(days);
		}
	}

	// 월말일 경우
	if (parseInt(CurDay) === 0 || parseInt(CurDay) < 0) {
		if (month === '01') {
			month = 12;
			CurYear--;
		} else {
			month--;
		}

		CurDay = MonthDays[month - 1];
		// 윤년 검사
		if (month === '2') {
			if (((CurYear % 4) == 0) && ((CurYear % 100) != 0)
					|| ((CurYear % 400) == 0)) {
				CurDay = 29;
			} else {
				CurDay = 28;
			}
		}
		if (parseInt(month) < 10)
			month = "0" + parseInt(month);
	}

	if (parseInt(CurDay) < 10)
		CurDay = "0" + parseInt(CurDay);

	if (CurYear < 100)
		CurYear = "19" + CurYear;
	TheDate = CurYear + gv_Data_Gubn + month + gv_Data_Gubn + CurDay;
	
	return TheDate;
}

// ////////////////////////////////////////////////////
// 조회일자 선택시 날짜 셋팅 함수
// ////////////////////////////////////////////////////
function beforeAddDate(startDateID, endDateID, dis) {
	if (typeof (startDateID) == 'undefined'
			|| typeof (endDateID) == 'undefined' || typeof (dis) == 'undefined') {
		return;
	}

	if (startDateID.charAt(0) != '#') {
		startDateID = '#' + startDateID;
	}

	if (endDateID.charAt(0) != '#') {
		endDateID = '#' + endDateID;
	}

	TheDate = getBeforeDate(endDateID, dis);
	
	$(startDateID).val(TheDate);
}
