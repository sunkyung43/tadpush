<!-- 연령 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">연령</span>
	<span class="setClear"> 
		<select id="target_age_enable" name="target_age_enable" onchange="javascript:changeTarget('age', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_age')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_age')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_age_layer" name="target_age_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_age')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<div id="target_age_tree"></div>
		</div>
	</div>
</div>
<!-- //연령 타게팅 -->