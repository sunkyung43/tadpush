<!-- 지역별 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">지역별</span>
	<span class="setClear"> 
		<select id="target_region_enable" name="target_region_enable" onchange="javascript:changeTarget('region', this.value);">
			<option value="1" <?php echo isset($selected_target_list[$this->lang->line('target_type_region')]) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list[$this->lang->line('target_type_region')]) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_region_layer" class="targetSet_view" <?php echo !isset($selected_target_list[$this->lang->line('target_type_region')]) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll">
		<div class="targetSetCheck">
			<input type="hidden" id="region_sido_cd" name="region_sido_cd" />
			<input type="hidden" id="region_gugun_cd" name="region_gugun_cd" />
			<div>
				<?php echo $target_region_sido_list;?>
				<span id="sigugun_selectbox" name="sigugun_selectbox"><select><option>구 선택</option></select></span>
				<a href="javascript:addRegionCode();"><img src="/web/images/button/0713_btn_add.gif" alt="추가" /></a>
			</div>
			<div>
				<select name="region_code_selected" id="region_code_selected" multiple="multiple" class="areaSelect">
				<?php if(isset($target_region_list)):?>
					<?php foreach($target_region_list as $row):?>
						<option value="<?php echo $row['region_cd'];?>"><?php echo $row['region_nm'];?></option>
					<?php endforeach;?>
				<?php endif;?>
				</select>
				<p class="btnAreaDel">
					<a href="javascript:removeRegionCode();"><img src="/web/images/button/btn_admin_Del.gif" alt="삭제" /></a>
				</p>
				<p class="areaSelInfo">※ 최대 10개 지역을 선택할 수 있습니다.</p>
			</div>
		</div>
	</div>
</div>
<!-- //지역별 타게팅 -->
