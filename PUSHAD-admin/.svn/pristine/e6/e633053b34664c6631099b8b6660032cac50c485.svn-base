<!-- 디바이스 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">디바이스</span>
	<span class="setClear"> 
		<select id="target_device_enable" name="target_device_enable" onchange="javascript:changeTarget('device', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_device')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_device')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_device_layer" name="target_device_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_device')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<div id="target_device_tree"></div>
		</div>
	</div>
	<div class="fileRegister" style="padding: 5px">
		직접등록
		<input type="file" style="width: 400px;" name="device_template" id="device_template" accept="application/vnd.ms-excel" onchange="javascript:uploadExcel(this.id, this.value);"/>
		<a href="javascript:downloadDeviceExcelTemplete();"><img src="/web/images/button/n_btn_down.gif" alt="양식 다운" /></a>
	</div>
</div>
<!-- //디바이스 타게팅 -->
