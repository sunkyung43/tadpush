<!-- OS 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">OS</span>
	<span class="setClear"> 
		<select id="target_os_enable" name="target_os_enable" onchange="javascript:changeTarget('os', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_os_ver')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_os_ver')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_os_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_os_ver')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<div id="target_os_tree"></div>
		</div>
	</div>
</div>
<!-- //OS 타게팅 -->