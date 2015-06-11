<!-- 미디어 타게팅 -->
<div class="targetSet targetSet_on">
	<span class="setName">미디어</span>
	<span class="setClear">
		<select id="target_media_enable" name="target_media_enable" onchange="javascript:changeTarget('media', this.value);">
			<option value="1" <?php echo isset($selected_target_list['MEDIA_NAME']) || isset($selected_target_list['MEDIA_GROUP']) || isset($selected_target_list['MEDIA_CATEGORY']) ? 'selected' : ''?>>설정</option>
			<option value="0" <?php echo !isset($selected_target_list['MEDIA_NAME']) && !isset($selected_target_list['MEDIA_GROUP']) && !isset($selected_target_list['MEDIA_CATEGORY']) ? 'selected' : ''?>>해제</option>
		</select>
	</span>
</div>
<div id="target_media_layer" class="targetSet_view" <?php echo !isset($selected_target_list['MEDIA_NAME']) && !isset($selected_target_list['MEDIA_GROUP']) && !isset($selected_target_list['MEDIA_CATEGORY']) ? 'style="display: none;"' : ''?>>
	<div class="targetSet_scroll" style="height: 500px;">
		<div class="mediaRadio">
			<input type="radio" id="mediaName" class="target_media_radio" name="target_media_type" value="name" <?php echo isset($selected_target_list['MEDIA_NAME']) ? 'checked="checked"' : ''?> />
			<label for="mediaName">미디어</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" id="premiumMedia" class="target_media_radio" name="target_media_type" value="group" <?php echo isset($selected_target_list['MEDIA_GROUP']) ? 'checked="checked"' : ''?> />
			<label for="premiumMedia">프리미엄 미디어 그룹</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" id="cata" class="target_media_radio" name="target_media_type" value="category" <?php echo isset($selected_target_list['MEDIA_CATEGORY']) ? 'checked="checked"' : ''?> />
			<label for="cata">카테고리</label>
		</div>
		
		<!-- 미디어 타게팅 -->
		<input type="hidden" id="media_name_cd" name="media_name_cd" />
		<div id="target_media_name_layer">
			<div class="mediaSrch">
				<input type="text" id="search_media" name="search_media" class="textType" title="미디어명 또는 미디어 ID를 검색어를 입력해 주세요" value="" style="width: 90%;" />
				<a href="javascript:searchMedia();"><img id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" /></a>
			</div>
			<div style="width: 96%; margin: 0 auto">
				<div class="n_class">
					<p>※ 검색 결과</p>
				</div>
				<div class="n_search">
					총 <span id="media_count" name="media_count" class="point01">0</span>건의 데이터가 검색되었습니다.
				</div>
				<div style="height: 130px; overflow-y: scroll; overflow-x: hidden;" class="clear">
					<table summary="미디어 관리" class="compaingTable">
						<colgroup>
							<col width="50%" />
							<col width="50%" />
						</colgroup>
						<thead>
							<tr>
								<th class="first">미디어</th>
								<th>APP ID</th>
							</tr>
						</thead>
						<tbody id="media_list" class="">
						</tbody>
					</table>
				</div>
			</div>
			<div class="textCenter" style="padding: 30px 0;">
				<a href="javascript:removeMedia();"><img src="/web/images/button/up_sadf_btn.gif" alt="up화살표" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:addMedia();"><img src="/web/images/button/down_sadf_btn.gif" alt="down화살표" /></a>
			</div>
			<div style="width: 96%; margin: 0 auto">
				<div class="n_class">
					<p>※ 선택 미디어</p>
				</div>
				<div class="n_search">
					총 <span id="selected_media_count" name="selected_media_count" class="point01">0</span>건의 데이터가 선택되었습니다.
				</div>
				<div style="height: 130px; overflow-y: scroll; overflow-x: hidden;" class="clear">
					<table summary="미디어 관리" class="compaingTable">
						<colgroup>
							<col width="50%" />
							<col width="50%" />
						</colgroup>
						<thead>
							<tr>
								<th class="first">미디어</th>
								<th>APP ID</th>
							</tr>
						</thead>
						<tbody id="selected_media">
						<?php if(isset($target_media_name_list)):?>
							<?php foreach($target_media_name_list as $row):?>
								<tr id="<?php echo $row['media_id'];?>">
									<td><?php echo $row['media_nm'];?></td>
									<td><?php echo $row['media_id'];?></td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="fileRegister mg_t10" style="padding: 5px">
				직접등록
				<input type="file" style="width: 400px;" name="media_template" id="media_template" accept="application/vnd.ms-excel" onchange="javascript:uploadExcel(this.id, this.value);"/>
				<a href="javascript:downloadMediaExcelTemplete();"><img src="/web/images/button/n_btn_down.gif" alt="양식 다운" /></a>
			</div>
		</div>
		<!-- //미디어 타게팅 -->
		
		<!-- 프리미엄 미디어 그룹 타게팅 -->
		<div id="target_media_group_layer">
			<div class="targetSetCheck">
				<div id="target_media_group_tree"></div>
			</div>
		</div>
		<!-- //프리미엄 미디어 그룹 타게팅 -->
		
		<!-- 카테고리 타게팅 -->
		<div id="target_media_category_layer">
			<div class="targetSetCheck">
				<div id="target_media_category_tree"></div>
			</div>		
		</div>
		<!-- //카테고리 타게팅 -->
	</div>
</div>
<!-- //미디어 타게팅 -->