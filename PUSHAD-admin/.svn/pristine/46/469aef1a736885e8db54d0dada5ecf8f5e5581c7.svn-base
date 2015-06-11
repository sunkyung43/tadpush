<span id="creative_PSCTTP102_layer" class="creative_PSCTTP102_layer">
	<!-- 이미지 소재정보 -->
	
	<?php echo $this->load->view('campaign/advert/creative/notification_bar_layer', $this, true);?>
	
	<h5 class="materialTit">※ Notification Drawer</h5>
	<table class="boardDataType" summary="소재 설정">
		<colgroup>
			<col width="15%" />
			<col width="" />
		</colgroup>
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
							640*128 이미지, 100kb 이하,<br />PNG, JPG 가능
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
		
	</table>
	<!-- //이미지 소재정보 -->
</span>