<div id="content">
	<form id="list_form" name="list_form">
		<div class="subTitleArea">
			<h3>Cross-marketing 광고 리스트</h3>
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
			<p class="textRight"><span class="dataResult">총 <strong><?php echo $total_rows;?></strong>건의 데이터가 검색되었습니다.</span>
			<a href="<?php echo $excel_url;?>"><img src="/web/images/button/excel_btn33.png" alt="엑셀 다운로드"/></a></p>
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
				<col width="5%">
			</colgroup>
			<thead>
				<tr>
					<th class="first"></th>
					<th>No</th>
					<th>캠페인 명</th>
					<th>광고 명</th>
					<th>광고주</th>
					<th>브랜드</th>
					<th>목표건수</th>
					<th>발송건수</th>
					<th>발송 현황</th>
					<th>상태</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!isset($list) || empty($list)): ?>
					<tr>
						<td colspan="10">검색결과가 없습니다.</td>
					</tr>
				<?php else: ?>
					<?php foreach($list as $advert_vo): ?>
					<tr>
						<td>
							<input type="hidden" id="ad_status_cd_<?php echo $advert_vo->get_ad_sq();?>" value="<?php echo $advert_vo->get_ad_status_cd();?>" />
							<input type="radio" name="ad_sq" id="ad_sq_<?php echo $advert_vo->get_ad_sq();?>" value="<?php echo $advert_vo->get_ad_sq();?>" <?php echo $advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_send') || $advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_com') ? 'disabled' : '';?> />
						</td>
						<td><?php echo $advert_vo->get_ad_sq();?></td>
						<td><?php echo $advert_vo->get_campaign_nm();?></td>
						<td><a href="javascript:location.replace('/campaign/advert/detail?list_type=advert&ad_sq=<?php echo $advert_vo->get_ad_sq();?>');"><?php echo $advert_vo->get_ad_nm(); ?></a></td>
						<td><?php echo $advert_vo->get_adv_company_nm();?></td>
						<td><?php echo $advert_vo->get_adv_brand_nm();?></td>
						<td><?php echo $advert_vo->get_push_booking_cnt();?></td>
						<td><?php echo $advert_vo->get_request_cnt();?></td>
						<?php if($this->config->item('ad_start_dt_edit') === TRUE):?>
							<?php if($advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_stand') && $advert_vo->get_sch_status_cd() == $this->lang->line('sch_status_file_com')):?>
								<td>
									<a href="javascript:location.replace('<?php echo sprintf('/test/test/advertBookingDateEdit?campaign_nm=%s&campaign_sq=%s&ad_nm=%s&ad_sq=%s&start_dt=%s', $advert_vo->get_campaign_nm(), $advert_vo->get_campaign_sq(), $advert_vo->get_ad_nm(), $advert_vo->get_ad_sq(), $advert_vo->get_start_dt());?>');">
									<?php echo $advert_vo->get_start_end_dt();?>
									</a>
								</td>
							<?php else:?>
								<td><?php echo $advert_vo->get_start_end_dt();?></td>
							<?php endif;?>
						<?php else:?>
							<td><?php echo $advert_vo->get_start_end_dt();?></td>
						<?php endif;?>
						<td><?php echo $advert_vo->get_ad_status_nm();?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	
		<?php echo $paging;?>
	
		<div class="mgT10">
			<p class="floatL"></p>
				<p class="floatL">
					<span class="inventoryText">선택 항목</span>
					<select class="mg_r10" id="execute_type" name="execute_type">
						<option value="">선택</option>
						<option value="<?php echo $this->lang->line('ad_status_stand');?>">발송</option>
						<option value="<?php echo $this->lang->line('ad_status_test');?>">취소</option>
					</select>
				</p>
			<p class="floatL"><a href="javascript:execute();"><img src="/web/images/button/btn_action.gif" alt="실행"></a></p>
			<p></p>
		</div>
	</form>
</div>