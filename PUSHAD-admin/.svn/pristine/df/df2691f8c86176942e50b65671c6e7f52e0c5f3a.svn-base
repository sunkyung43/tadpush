<!-- 통신사 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">통신사</span>
	<span class="setClear"> 
		<select id="target_carrier_enable" name="target_carrier_enable" onchange="javascript:changeTarget('carrier', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_carrier_cd')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_carrier_cd')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_carrier_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_carrier_cd')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<div id="target_carrier_tree"></div>
		</div>
	</div>
</div>
<!-- //통신사 타게팅 -->
