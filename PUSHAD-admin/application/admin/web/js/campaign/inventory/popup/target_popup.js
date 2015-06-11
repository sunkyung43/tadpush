$(document).ready(function() {
	initTargetMedia();

	checkRegionCode();
});

function target_setting() {
	opener.$("#os_ver").val("");
	opener.$("#model_nm").val("");
	opener.$("#carrier_cd").val("");
	opener.$("#gender_cd").val("");
	opener.$("#age_rng_cd").val("");
	opener.$("#region_sido_cd").val("");
	opener.$("#region_gugun_cd").val("");
	opener.$("#media_name_cd").val("");
	opener.$("#media_group_cd").val("");
	opener.$("#media_category_cd").val("");

	if($("#target_os_enable :selected").val() == "1") {
		opener.$("#os_ver").val($("#os_ver").val());
	}
	if($("#target_device_enable :selected").val() == "1") {
		opener.$("#model_nm").val($("#model_nm").val());
	}
	if($("#target_carrier_enable :selected").val() == "1") {
		opener.$("#carrier_cd").val($("#carrier_cd").val());
	}
	if($("#target_gender_enable :selected").val() == "1") {
		opener.$("#gender_cd").val($("#gender_cd").val());
	}
	if($("#target_age_enable :selected").val() == "1") {
		opener.$("#age_rng_cd").val($("#age_rng_cd").val());
	}
	if($("#target_region_enable :selected").val() == "1") {
		opener.$("#region_sido_cd").val($("#region_sido_cd").val());
		opener.$("#region_gugun_cd").val($("#region_gugun_cd").val());
	}
	if($("#target_media_enable :selected").val() == "1") {
		if($(":radio[name='target_media_type']:checked").val() == 'name') {
			opener.$("#media_name_cd").val($("#media_name_cd").val());
		} else if($(":radio[name='target_media_type']:checked").val() == 'group') {
			opener.$("#media_group_cd").val($("#media_group_cd").val());
		} else if($(":radio[name='target_media_type']:checked").val() == 'category') {
			opener.$("#media_category_cd").val($("#media_category_cd").val());
		}
	}
	
	opener.$("#target_off_img").hide();
	opener.$("#target_on_img").show();
	
	opener.$("#reset_off_img").hide();
	opener.$("#reset_on_img").show();

	window.close();
}
