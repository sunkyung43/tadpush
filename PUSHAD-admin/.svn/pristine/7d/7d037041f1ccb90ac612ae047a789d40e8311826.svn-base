<tr>
	<th>Large Icon <strong class="important">*</strong></th>
	<td class="WriteLft end">
		<input type="hidden" class="" id="large_icon_image" name="large_icon_image" value="<?php echo $creative_vo->get_large_icon_image();?>"/>
		<input type="file" style="width: 40%" accept="<?php echo $this->config->item('file_accept_types');?>" id="large_icon_image_file" name="large_icon_image_file" autocomplete="off" onchange="javascript:uploadImage(this.id, this.value);"/>
		<!-- 설명레이어팝업 -->
		<div class="infoZone">
			<a href="javascript:tooltipPopup('large_icon_image_tooltip', true);"><img src="/web/images/button/qMark.gif" alt="설명" /></a>
			<div id="large_icon_image_tooltip" class="layerPopup_new" style="display: none;">
				<p class="text">
					200*200 Icon, 10kb 이하,<br />PNG, JPG 가능
				</p>
				<p class="btn">
					<a href="javascript:tooltipPopup('large_icon_image_tooltip', false);"><img src="/web/images/button/check.gif" alt="확인" /></a>
				</p>
			</div>
		</div>
		<!-- //설명레이어팝업 -->
	</td>
</tr>
<tr>
	<th>미리보기</th>
	<td class="WriteLft end">
		<img id="large_icon_image_preview" src="<?php echo $creative_vo->get_large_icon_image();?>"/>
	</td>
</tr>