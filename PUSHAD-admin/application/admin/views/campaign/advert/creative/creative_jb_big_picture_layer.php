<span id="creative_PSCTTP110_layer" name="creative_PSCTTP110_layer" class="creative_layer">
	<!-- JB-Big Picture 소재정보 -->
	
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
				(권장 13자, 최대 25자)
			</td>
		</tr>
		<tr>
			<th>Summary Text</th>
			<td class="WriteLft end">
				<input type="text" id="summary_text" name="summary_text" value="<?php echo $creative_vo->get_summary_text();?>" style="width: 40%" />
				(권장 13자, 최대 25자)</td>
		</tr>
		<tr>
			<th>Banner Image <strong class="important">*</strong></th>
			<td class="WriteLft end">
				<input type="hidden" class="" id="banner_image" name="banner_image" value="<?php echo $creative_vo->get_banner_image();?>"/>
				<input type="file" style="width: 40%" accept="<?php echo $this->config->item('file_accept_types');?>" id="banner_image_file" name="banner_image_file" autocomplete="off" onchange="javascript:uploadImage(this.id, this.value);"/>
				<!-- 설명레이어팝업 -->
				<div class="infoZone">
					<a href="javascript:tooltipPopup('banner_image_tooltip', true);"><img src="/web/images/button/qMark.gif" alt="설명" /></a>
					<div id="banner_image_tooltip" class="layerPopup_new" style="display: none;">
						<p class="text">
							640*256 이미지, 200kb 이하,<br />PNG, JPG 가능
						</p>
						<p class="btn">
							<a href="javascript:tooltipPopup('banner_image_tooltip', false);"><img src="/web/images/button/check.gif" alt="확인" /></a>
						</p>
					</div>
				</div> <!-- //설명레이어팝업 --></td>
		</tr>
		<tr>
			<th>미리보기</th>
			<td class="WriteLft end">
				<img id="banner_image_preview" src="<?php echo $creative_vo->get_banner_image();?>"/>
			</td>
		</tr>
		
		<?php echo $this->load->view('campaign/advert/creative/landing/landing_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/creative/landing/action_landing_layer', $this, true);?>
		
	</table>
	<!-- //JB-Big Picture 소재정보 -->
</span>