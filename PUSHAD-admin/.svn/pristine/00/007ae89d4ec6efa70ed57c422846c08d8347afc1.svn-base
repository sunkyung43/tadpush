<div id="content">
	<div class="subTitleArea">
		<h3>프리미엄 미디어 그룹</h3>
	</div>
	<!-- //subTitleArea -->
	<hr>
	<form id="list_form" name="list_form">
	<div class="searchArea02">
		<div class="n_class">
			<?php echo $paging_volume;?>
		</div>
		<div class="n_search">
			총 <span class="point01"><?php echo count($list);?></span>건의 데이터가 검색되었습니다.
		</div>
	</div>

	<table summary="프리미엄 미디어 그룹 관리" class="compaingTable">
		<colgroup>
			<col width="7%">
			<col width="10%">
			<col width="*">
			<col width="15%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th class="first"></th>
				<th>그룹</th>
				<th>그룹 설명</th>
				<th>미디어 수</th>
				<th>등록일</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="5">등록된 프리미엄  미디어 그룹이 없습니다.</td>
			</tr>
		<?php else: ?>
		<?php foreach($list as $mediaGroup_vo): ?>
			<tr>
				<td><input type="radio" value="<?php echo $mediaGroup_vo->get_media_group_id();?>" name="media_group_id" class="checkType"></td>
				<td><a href="/system/target/mediaGroup_write?type=detail&media_group_id=<?php echo $mediaGroup_vo->get_media_group_id();?>"><?php echo $mediaGroup_vo->get_media_group_id();?></a></td>
				<td><?php echo $mediaGroup_vo->get_media_group_desc();?></td>
				<td><?php echo $mediaGroup_vo->get_media_cnt();?></td>
				<td><?php echo $mediaGroup_vo->get_create_dt();?></td>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>

	<div class="pagingList mg_t10">
		<?php echo $paging;?>
	</div>

	<div class="btnListArea">
		<div class="floatL">
			<span class="inventoryText">선택한 항목을</span> 
			<?php echo $action_selectbox;?>
			<a href="javascript:executeAction();">
				<img src="../../web/images/button/btn_action.gif" alt="실행"></a>
		</div>
		<p class="floatR">
			<a href="/system/target/mediaGroup_write?createYN=Y"><img src="../../web/images/button/reg.gif" alt="등록"></a>
		</p>
	</div>
</form>
</div>
