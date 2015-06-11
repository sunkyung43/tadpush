<div id="popTop">
	<h2>
		등록 광고 
		<a href="#" class="closePopup" onclick="window.close();" style="line-height:0px;">
			<img src="/web/images/button/close_popup.gif" alt="창 닫기" />
		</a>
	</h2>
</div>
<div class="popWrapper">
	<table class="compaingTable" summary="캠페인 리스트">
		<colgroup>
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
				<th class="first">No</th>
				<th>캠페인 명</th>
				<th>광고 명</th>
				<th>광고주</th>
				<th>브랜드</th>
				<th>목표건수</th>
				<th>달성건수</th>
				<th>발송 현황</th>
				<th>상태</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="9">검색결과가 없습니다.</td>
				</tr>
			<?php else: ?>
				<?php foreach($list as $advert_vo): ?>
				<tr>
					<td><?php echo $advert_vo->get_ad_sq();?></td>
					<td><?php echo $advert_vo->get_campaign_nm();?></td>
					<td><?php echo $advert_vo->get_ad_nm() ?></td>
					<td><?php echo $advert_vo->get_adv_company_nm();?></td>
					<td><?php echo $advert_vo->get_adv_brand_nm();?></td>
					<td><?php echo $advert_vo->get_push_booking_cnt();?></td>
					<td><?php echo $advert_vo->get_request_cnt();?></td>
					<td><?php echo $advert_vo->get_start_dt();?></td>
					<td><?php echo $advert_vo->get_ad_status_nm();?></td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	
	<?php echo $paging;?>
</div>
<div class="alignC">
	<a href="#" onclick="window.close();">
		<img src="/web/images/button/close.gif" alt="닫기" />
	</a>
</div>