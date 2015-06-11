<span id="creative_PSCTTP105_layer" class="creative_PSCTTP105_layer"> 
	<!-- 팝업-이미지 소재정보 -->
	
	<?php echo $this->load->view('campaign/advert/creative/notification_bar_layer', $this, true);?>
	
	<h5 class="materialTit">※ Notification Drawer</h5>
	<table class="boardDataType" summary="소재 설정">
		<colgroup>
			<col width="15%">
			<col width="">
		</colgroup>
		<tbody>
		
			<?php echo $this->load->view('campaign/advert/creative/image/large_icon_image_layer', $this, true);?>
		
			<tr>
				<th>Content Title <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="text" id="content_title" name="content_title" value="<?php echo $creative_vo->get_content_title();?>" style="width: 40%" />
					 (권장 13자, 최대 25자)
				</td>
			</tr>
			<tr>
				<th>Content Text <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="text" id="content_text" name="content_text" value="<?php echo $creative_vo->get_content_text();?>" style="width: 40%" />
					(권장 13자, 최대 25자)
				</td>
			</tr>
			<tr>
				<th>Popup Image <strong class="important">*</strong></th>
				<td class="WriteLft end">
					<input type="hidden" class="" id="popup_image" name="popup_image" value="<?php echo $creative_vo->get_popup_image();?>"/>
					<input type="file" style="width: 40%" accept="<?php echo $this->config->item('file_accept_types');?>" id="popup_image_file" name="popup_image_file" autocomplete="off" onchange="javascript:uploadImage(this.id, this.value);"/>
					<!-- 설명레이어팝업 -->
					<div class="infoZone">
						<a href="javascript:tooltipPopup('popup_image_tooltip', true);"><img src="/web/images/button/qMark.gif" alt="설명" /></a>
						<div id="popup_image_tooltip" class="layerPopup_new2" style="display: none;">
							<p class="text">
								640*256 이미지, 100kb 이하,<br>PNG, JPG 가능
							</p>
							<p class="btn">
								<a href="javascript:tooltipPopup('popup_image_tooltip', false);"><img src="/web/images/button/check.gif" alt="확인" /></a>
							</p>
						</div>
					</div>
					<!-- //설명레이어팝업 -->
				</td>				
			</tr>
			<tr>
				<th>미리보기</th>
				<td class="WriteLft end">
					<img id="popup_image_preview" src="<?php echo $creative_vo->get_popup_image();?>"/>
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
