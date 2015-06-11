$(document).ready(function() {
	initCalendar();
});

function initCalendar() {
	var calendar_max_week = $("#calendar_max_week").val();
	create_single_calendar('start_dt', calendar_max_week, 0);
	
	var date = new Date();
	$("#start_dt").datepicker("setDate", date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate());
}

function targeting() {
	var querystring = get_target_querystring();
	window.open('/campaign/inventory/target?' + querystring, 'campaignTargetPopup', 'width=1200, height=600, left=50, top=50, scrollbars=yes');
}

function search() {
	var querystring = get_target_querystring();
	window.open('/campaign/inventory/remain?' + querystring, 'inventoryRemainPopup', 'width=600, height=560, left=50, top=50, scrollbars=yes');	
}

function get_target_querystring() {
	var querystring = '';
	
	querystring += 'start_dt=' + $("#start_dt").val();
	querystring += '&os_ver=' + $("#os_ver").val();
	querystring += '&model_nm=' + $("#model_nm").val();
	querystring += '&carrier_cd=' + $("#carrier_cd").val();
	querystring += '&gender_cd=' + $("#gender_cd").val();
	querystring += '&age_rng_cd=' + $("#age_rng_cd").val();
	querystring += '&region_sido_cd=' + $("#region_sido_cd").val();
	querystring += '&region_gugun_cd=' + $("#region_gugun_cd").val();
	querystring += '&media_name_cd=' + $("#media_name_cd").val();
	querystring += '&media_group_cd=' + $("#media_group_cd").val();
	querystring += '&media_category_cd=' + $("#media_category_cd").val();
	
	return querystring;
}

function reset() {
	$("#os_ver").val("");
	$("#model_nm").val("");
	$("#carrier_cd").val("");
	$("#gender_cd").val("");
	$("#age_rng_cd").val("");
	$("#region_sido_cd").val("");
	$("#region_gugun_cd").val("");
	$("#media_name_cd").val("");
	$("#media_group_cd").val("");
	$("#media_category_cd").val("");
	
	$("#target_on_img").hide();
	$("#target_off_img").show();
	
	$("#reset_on_img").hide();
	$("#reset_off_img").show();
}

function advertListPopup(start_dt) {
	window.open('/campaign/advert/adListPopup?start_dt=' + start_dt, 'advertListPopup', 'width=1200, height=600, left=50, top=50, scrollbars=yes');
}
