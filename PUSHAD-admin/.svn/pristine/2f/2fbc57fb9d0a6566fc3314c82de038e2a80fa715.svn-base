<div id="content">
	<form id="list_form" name="list_form">
		<div class="subTitleArea">
			<h3>Cross-marketing 미디어</h3>
		</div>

		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_class">
				<strong class="title">상태</strong>
				<?php echo $media_status_selectbox;?>
				<strong class="title">플랫폼</strong>
				<?php echo $flatform_selectbox;?>
				<strong class="title">카테고리</strong>
				<?php echo $category_selectbox;?>
			</div>
			<div class="n_search">
				<strong class="title">검색조건</strong>
				<?php echo $search_type_selectbox;?>
				<input type="text" id="search_value" name="search_value" class="textType" title="검색어 입력" value="<?php echo $search_value;?>">
				<img id="BTN_SEARCH" src="../../web/images/button/search.gif" alt="검색" onclick="search();" style="cursor: pointer;">
			</div>
		</div>
		<!--// 검색 -->

		<p class="dotLine"></p>
		
		<div class="searchArea02">
			<div class="n_class">
				<?php echo $paging_volume;?>
			</div>
			<p class="textRight"><span class="dataResult">총 <strong><?php echo $total_rows;?></strong>건의 데이터가 검색되었습니다.</span> 
				<a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a>
			</p>
		</div>

		<table class="compaingTable" summary="캠페인 리스트">
			<colgroup>
				<col width="5%">
				<col width="5%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
			</colgroup>
			<thead>
				<tr>
					<th class="first"></th>
					<th>No</th>
					<th>등록일</th>
					<th>미디어</th>
					<th>APP ID</th>
					<th>플랫폼</th>
					<th>카테고리</th>
					<th>상태</th>
					<th>최종 수정일</th>
				</tr>
			</thead>
			<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="9">검색결과가 없습니다.</td>
				</tr>
			<?php else: ?>
			<?php foreach($list as $media_vo): ?>
			<tr>
				<td><input type="radio" name="select_media_id" value="<?php echo $media_vo->get_media_id();?>"></td>
				<td><?php echo $media_vo->get_media_id();?></td>
				<td><?php echo $media_vo->get_create_dt();?></td>
				<td><a href="/media/media/detail?type=detail&media_id=<?php echo $media_vo->get_media_id();?>" ><?php echo $media_vo->get_media_nm();?></a></td>
				<td><?php echo $media_vo->get_media_id();?></td>
				<td><?php echo $media_vo->get_os_nm();?></td>
				<td><?php echo $media_vo->get_media_category_nm();?></td>
				<td><?php echo $media_vo->get_media_status_nm();?></td>
				<td><?php echo $media_vo->get_update_dt();?></td>
			</tr>
			<?php endforeach;?>
			<?php endif; ?>
			</tbody>
		</table>

		<?php echo $paging;?>

		<div class="mgT10">
			<p class="floatL">
				<span class="inventoryText">선택 항목</span>
				<select id="actionType" name="actionType" class="mg_r10">
					<option value="">선택</option>
					<option value="popup">미디어 리포트 보기</option>
					<option value="delete">삭제</option>
				</select>
			</p>
			<p class="floatL"><a href="javascript:executeAction();"><img src="../../web/images/button/btn_action.gif" alt="실행"></a></p>
			<p class="floatR"><a href="/media/media/detail?type=write"><img src="../../web/images/button/reg.gif" alt="등록"></a></p>
		</div>
	</form>
</div>