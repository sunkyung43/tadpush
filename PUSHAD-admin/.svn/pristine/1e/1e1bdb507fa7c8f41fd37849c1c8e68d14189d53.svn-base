<div id="content">
	<div class="subTitleArea">
		<h3>Cross-marketing 미디어</h3>
	</div>
	<hr>
	<form id="write_form" name="write_form">
	<input name="media_id" type="hidden" value="<?php echo $media->get_media_id();?>">
	<input id="before_group_ids" name="before_group_ids" type="hidden" value="">
	<input id="after_group_ids" name="after_group_ids" type="hidden" value="">
		<table class="boardDataType mg_t10" summary="">
			<colgroup>
				<col width="13%">
				<col width="37%">
				<col width="13%">
				<col width="37%">
			</colgroup>
			<tbody>
				<tr>
					<th>미디어 명</th>
					<td class="WriteLft end">
						<input id="media_nm" name="media_nm" type="text" value="<?php echo $media->get_media_nm();?>" style="width: 80%;"> 
						<input id="before_media_nm" name="before_media_nm" type="hidden" value="<?php echo $media->get_media_nm();?>" style="width: 80%;">
						<span id="media_nm_count"><strong class="point01">0</strong> / 30자</span>
					</td>
					<th>등록일</th>
					<td class="WriteLft end">
						<?php echo $media->get_create_dt();?>
					</td>
				</tr>
				<tr>
					<th>플랫폼</th>
					<td class="WriteLft end">
						<?php echo $flatform_selectbox;?>
						<input type="hidden" name="before_os_cd" value="<?php echo $media->get_os_cd();?>"/>
					</td>
					<th>최종 수정일</th>
					<td class="WriteLft end">
						<?php echo $media->get_update_dt();?>
					</td>
				</tr>
				<tr>
					<th>상태</th>
					<td class="WriteLft end">
						<?php echo $media_status_selectbox;?>
						<input type="hidden" name="before_status" value="<?php echo $media->get_media_status_cd();?>"/>
					</td>
					<th>APP ID</th>
					<td class="WriteLft end"><?php echo $media->get_media_id();?></td>
				</tr>
				<tr>
					<th>카테고리</th>
					<td class="WriteLft end">
						<?php echo $category_selectbox;?>
						<input type="hidden" name="before_category" value="<?php echo $media->get_media_category_cd();?>"/>
					</td>
					<th>APP Key</th>
					<td class="WriteLft end"><?php echo $media->get_media_key();?></td>
				</tr>
				<tr>
					<th>그룹 설정</th>
					<td class="WriteLft end">
						<?php if (!isset($used_media_group_list) || empty($used_media_group_list)): ?>
						<?php else: ?>
						<?php foreach($used_media_group_list as $row): ?>
						<input type="checkbox" name="media_group_ids[]" value="<?php echo $row['media_group_id'];?>" 
							<?php if($row['checkyn'] == "Y"):?>
								checked="checked" <?php echo $row['checkyn'];?>
							<?php else:?>
							<?php endif;?>>
						<?php echo $row['media_group_nm']?>
						<?php endforeach;?>
						<?php endif;?>
					</td>
					<th>APP Secret</th>
					<td class="WriteLft end"><?php echo $media->get_media_secret();?></td>
				</tr>
				<tr>
					<th>보유 모수</th>
					<td class="WriteLft end">
						<?php echo $media->get_hold_param_cnt();?>
					</td>
					<th>비고</th>
					<td class="WriteLft end">
						<input id="media_desc" name="media_desc" type="text" value="<?php echo $media->get_media_desc();?>" style="width: 80%" />
						<input type="hidden" name="before_media_desc" type="text" value="<?php echo $media->get_media_desc();?>" style="width: 80%" />
						<span id="media_desc_count"><strong class="point01">0</strong> / 100자</span>
					</td>
				</tr>
			</tbody>
		</table>
	</form>

	<div class="btnC">
		<?php if ($type == 'write') :?>
		<span>
			<a href="javascript:executeSave();"><img src="../../web/images/button/reg.gif" alt="등록"></a>
		</span> 
		<?php else :?>
			<?php if ($isPopup == 'N') :?>
			<span>
				<a href="javascript:executeUpdate();"><img src="../../web/images/button/btn_modify.gif" alt="수정" ></a>
			</span> 
			<?php endif;?>
		<span>
			<a href="javascript:openPopup(<?php echo $media->get_media_id()?>)"><img src="../../web/images/button/view_media_modify.gif" alt="정보변경 이력보기"></a>
		</span>
		<?php endif;?>
		<span>
			<a href="/media/media"><img src="../../web/images/button/n_btn_list.gif" alt="목록" style="cursor: pointer;"></a>
		</span>
	</div>

</div>