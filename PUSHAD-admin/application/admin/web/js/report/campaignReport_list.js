 function search() {
		var params = $("#list_form").serialize();
	location.replace('/report/pcpCampaignReport?' + params);
}