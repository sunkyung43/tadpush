<script type="text/javascript">
<!--

//-->
</script>

<div id="content">
	<div class="subTitleArea">
		<h3>프리미엄 미디어 그룹</h3>
	</div>
	<hr>
	<form id="write_form" name="write_form">
	<input id="createYN" name="createYN" value="<?php echo $createYN;?>" type="hidden">
	<input type="hidden" id="media_name_cd" name="media_name_cd">
	<input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
	<table class="boardDataType mg_t10" summary="프리미엄 미디어 그룹 등록">
		<colgroup>
			<col width="15%">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th>* 그룹선택</th>
				<td class="WriteLft end"><?php echo $groupList_selectbox;?></td>
			</tr>
			<tr>
				<th>* 그룹설명</th>
				<td>
				<?php if(isset($info)):?>
					<input type="text" id="media_group_desc" name="media_group_desc" class="" style="width:90%;" value="<?php echo $info->get_media_group_desc();?>">
				<?php else :?>
					<input type="text" id="media_group_desc" name="media_group_desc" class="" style="width:90%;" value="">
				<?php endif;?>
					<span id="desc_validate"><strong class="counting">0</strong> / 200자</span>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="targetCent" style="display: block; padding-top: 30px;">
		<input type="text" id="search_media" name="search_media" style="width:90%;height:17px; " value="">
		<a href="javascript:searchMedia();"><img id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" /></a>
		<div class="searchArea02 mg_t20">
			<div class="n_class">
				<p>※ 검색 결과</p>
			</div>
			<div class="n_search">
				총 <span id="media_count" class="point01">0</span>건의 데이터가 검색되었습니다.
			</div>
		</div>

		<div
			style="height: 150px; overflow-y: scroll; border: 1px solid #dedede">
			<table summary="프리미엄 미디어 그룹 관리" class="compaingTable">
				<colgroup>
					<col width="50%">
					<col width="50%">
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

		<div class="textCenter" style="padding: 30px 0;">
				<a href="javascript:removeMedia();"><img src="/web/images/button/up_sadf_btn.gif" alt="up화살표" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:addMedia();"><img src="/web/images/button/down_sadf_btn.gif" alt="down화살표" /></a>
		</div>

		<div class="searchArea02 mg_t20">
			<div class="n_class">
				<p>※ 선택미디어</p>
			</div>
			<div class="n_search">
					총 <span id="selected_media_count" name="selected_media_count" class="point01">0</span>건의 데이터가 선택되었습니다.
			</div>
		</div>
		<div
			style="height: 150px; overflow-y: scroll; border: 1px solid #dedede">
			<table summary="프리미엄 미디어 그룹 관리" class="compaingTable">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tbody id="selected_media">
					<?php if(isset($list)):?>
							<?php foreach($list as $row):?>
								<tr id="<?php echo $row->get_media_id();?>">
									<td><?php echo $row->get_media_nm();?></td>
									<td><?php echo $row->get_media_id();?></td>
								</tr>
							<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
		</div>
	</div>
	</form>
	<div class="btnC">
		<?php if($type == 'detail') :?>
		<span><a href="javascript:executeSave();"><img src="../../web/images/button/btn_modify.gif" alt="등록" ></a></span>
		<?php else :?>
		<span><a href="javascript:executeSave();"><img src="../../web/images/button/reg.gif" alt="등록" ></a></span>
		<?php endif;?>
		<span><a href="javascript:content_cancel();"><img src="../../web/images/button/cancel03.gif" alt="취소"></a></span>
	</div>

</div>