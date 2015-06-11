<span id="creative_PSCTTP107_layer" name="creative_PSCTTP107_layer" class="creative_layer">
	<!-- JB-Default 소재정보 -->
	
	<?php echo $this->load->view('campaign/advert/creative/notification_bar_layer', $this, true);?>
	
	<h5 class="materialTit">※ Notification Drawer</h5>
	<table class="boardDataType" summary="소재 설정">
		<colgroup>
			<col width="15%" />
			<col width="" />
		</colgroup>
		
		<?php echo $this->load->view('campaign/advert/creative/image/large_icon_image_layer', $this, true);?>

		<tr>
			<th>Content Title <strong class="important">*</strong></th>
			<td class="WriteLft end">
				<input type="text" id="content_title" name="content_title" value="<?php echo $creative_vo->get_content_title();?>" style="width: 40%" />
				(권장 13자, 최대 25자)</td>
		</tr>
		<tr>
			<th>Content Text <strong class="important">*</strong></th>
			<td class="WriteLft end">
				<input type="text" id="content_text" name="content_text" value="<?php echo $creative_vo->get_content_text();?>" style="width: 40%" />
				(권장 13자, 최대 25자)</td>
		</tr>

		<?php echo $this->load->view('campaign/advert/creative/landing/landing_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/creative/landing/action_landing_layer', $this, true);?>
		
	</table>
	<!-- //JB-Default 소재정보 -->
</span>