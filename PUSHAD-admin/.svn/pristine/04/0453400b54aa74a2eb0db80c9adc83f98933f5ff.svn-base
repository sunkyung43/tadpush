<script type="text/javascript">
	$(document).ready(function() {
		create_dual_calendar('#searchStartDate', '#searchEndDate', true);
	});
</script>
<div id="content">
	
	<div class="subTitleArea">
		<h3>Device 기종 관리</h3>
	</div>
	<form name="list_form" name="list_form">
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_search">
				<strong class="title">검색조건</strong> 출시년월 
				<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $start_dt;?>"> ~ 
				<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $end_dt;?>">
				<?php echo $search_type_selectbox;?> 
				<input type="text" id="search_value" name="search_value" class="textType mg_l10" title="검색어 입력" value=""> 
				<img id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" onclick="javascript: list_form.submit()" style="cursor: pointer;">
			</div>
		</div>
		<!--// 검색 -->
		<div class="searchArea02">
			<div class="n_class">
				<div class="n_class">
					<?php echo $paging_volume;?>
				</div>
			</div>
			<p class="textRight"><a href="<?php echo $excel_url;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a></p>
		</div>
	</form>

	<table class="compaingTable" summary="Device기종 관리">
		<colgroup>
			<col width="10%">
			<col width="16%">
			<col width="15%">
			<col width="15%">
			<col width="15%">
			<col width="15%">
			<col width="14%">
		</colgroup>
		<thead>
			<tr>
				<th class="first">No</th>
				<th>Device Type</th>
				<th>제조사</th>
				<th>단말(브랜드)명</th>
				<th>모델명</th>
				<th>출시년월</th>
				<th class="end">등록일</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="7">검색(등록)된 디바이스가  없습니다.</td>
			</tr>
			<?php else: ?>
			<?php foreach($list as $device_vo): ?>
			<tr>
				<td><?php echo $device_vo->get_device_sq();?></td>
				<td><?php echo $device_vo->get_device_type_nm();?></td>
				<td><?php echo $device_vo->get_maker_nm();?></td>
				<td><a href="#"><?php echo $device_vo->get_brand_nm();?></a></td>
				<td><?php echo $device_vo->get_model_nm();?></td>
				<td><?php echo $device_vo->get_release_dt();?></td>
				<td><?php echo $device_vo->get_create_dt();?></td>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>
	<div class="btnListArea">
		<p class="floatR">
			<a href="javascript:alert('준비중입니다.')">
				<img src="/web/images/button/btn_newDevice.gif" alt="신규 Device 등록"> 
			</a>
		</p>
	</div>
</div>