<!-- 성별 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">성별</span>
	<span class="setClear"> 
		<select id="target_gender_enable" name="target_gender_enable" onchange="javascript:changeTarget('gender', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_gender')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_gender')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_gender_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_gender')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<div id="target_gender_tree"></div>
		</div>
	</div>
</div>
<!-- //성별 타게팅 -->