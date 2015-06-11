<!--컨텐츠 -->
<div id="content">
	<form id="list_form" name="list_form">
		<div class="subTitleArea">
			<h3>Cross-marketing 캠페인 리스트</h3>
		</div>
	
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_class">
				<strong class="title">상태</strong>
				<?php echo $ad_status_selectbox;?>
			</div>
			<div class="n_search">
				<strong class="title">검색조건</strong>
				<?php echo $search_type_selectbox;?>
				<input type="text" id="search_value" name="search_value" class="textType" title="검색어 입력" value="<?php echo $search_value;?>" />
				<a href="javascript:search();"><img id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" /></a>
			</div>
		</div>
		<!--// 검색 -->
	
		<p class="dotLine"></p>
		
		<div class="searchArea02">
			<div class="n_class">
				<?php echo $paging_volume;?>
			</div>
			<p class="textRight">
				<span class="dataResult">총 <strong><?php echo $total_rows;?></strong>건의 데이터가 검색되었습니다.</span>
				<a href="<?php echo $excel_url;?>"><img src="/web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
		</div>
	
		<table class="compaingTable" summary="캠페인 리스트">
			<colgroup>
				<col width="5%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="%">
				<col width="5%">
				<col width="5%">
				<col width="5%">
			</colgroup>
			<thead>
				<tr class="2block">
					<th rowspan="2" class="first"></th>
					<th rowspan="2">No</th>
					<th rowspan="2">캠페인 명</th>
					<th rowspan="2">광고주</th>
					<th rowspan="2">브랜드</th>
					<th rowspan="2">기간</th>
					<th rowspan="2">진행현황<br/>(발송/목표)</th>
					<th colspan="3">광고 현황</th>
				</tr>
				<tr class="2block">
					<th>검수</th>
					<th>대기</th>
					<th>완료</th>
				</tr>
			</thead>
			<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="10">검색결과가 없습니다.</td>
				</tr>
			<?php else: ?>
				<?php foreach($list as $campaign_vo): ?>
				<tr>
					<td><input type="radio" name="campaign_sq" id="campaign_sq_<?php echo $campaign_vo->get_campaign_sq();?>" value="<?php echo $campaign_vo->get_campaign_sq();?>" <?php echo $campaign_vo->get_tot_ad_cnt() > 0 ? 'disabled' : '';?>/></td>
					<td><?php echo $campaign_vo->get_campaign_sq();?></td>
					<td><a href="javascript:location.replace('/campaign/campaign/detail?campaign_sq=<?php echo $campaign_vo->get_campaign_sq();?>');"><?php echo $campaign_vo->get_campaign_nm() ?></a></td>
					<td><?php echo $campaign_vo->get_adv_company_nm();?></td>
					<td><?php echo $campaign_vo->get_adv_brand_nm();?></td>
					<td><?php echo $campaign_vo->get_tot_campaign_dt();?></td>
					<td><?php echo $campaign_vo->get_tot_booking_and_request_cnt();?></td>
					<td><?php echo $campaign_vo->get_tot_test_cnt();?></td>
					<td><?php echo $campaign_vo->get_tot_ready_cnt();?></td>
					<td><?php echo $campaign_vo->get_tot_complete_cnt();?></td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	
		<?php echo $paging;?>
	
		<div class="mgT10">
			<p class="floatL">
				<p class="floatL">
					<span class="inventoryText">선택 항목</span>
					<select class="mg_r10" id="execute_type" name="execute_type">
						<option value="">선택</option>
						<option value="delete">삭제</option>
					</select>
				</p>
				<p class="floatL"><a href="javascript:execute();"><img src="/web/images/button/btn_action.gif" alt="실행" /></a></p>
			</p>
			<p class="n_search"><a href="javascript:location.replace('/campaign/campaign/write');"><img src="/web/images/button/reg.gif" alt="등록" /></a></p>
		</div>
	</form>
</div>
<!-- //content-->
