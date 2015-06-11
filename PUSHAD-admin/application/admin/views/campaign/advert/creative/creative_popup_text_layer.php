<span id="creative_PSCTTP104_layer" class="creative_PSCTTP104_layer"> 
	<!-- 팝업 소재정보 -->
	
	<?php echo $this->load->view('campaign/advert/creative/notification_bar_layer', $this, true);?>
	
	<h5 class="materialTit">※ Notification Drawer</h5>
	<table class="boardDataType" summary="소재 설정">
		<colgroup>
			<col width="15%">
			<col width="">
		</colgroup>
		<tbody>
			<tr>
				<th>Popup Title <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="text" id="popup_title" name="popup_title" value="<?php echo $creative_vo->get_popup_title();?>" style="width: 40%">
					 (권장 10자, 최대 20자)
				</td>
			</tr>
			<tr>
				<th>Popup Content Text <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="text" id="popup_content_text" name="popup_content_text" value="<?php echo $creative_vo->get_popup_content_text();?>" style="width: 40%">
					 (권장 50자, 최대 100자)
				</td>
			</tr>
			<tr>
				<th>Landing Button Title <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="text" id="landing_button_title" name="landing_button_title" value="<?php echo $creative_vo->get_landing_button_title();?>" style="width: 40%">
					 (권장 5자, 최대 10자)
				</td>
			</tr>

			<?php echo $this->load->view('campaign/advert/creative/landing/landing_layer', $this, true);?>
			
		</tbody>
	</table>
</span>
