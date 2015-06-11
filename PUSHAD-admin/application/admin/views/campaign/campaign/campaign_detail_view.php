<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>Cross-marketing 캠페인 리스트</h3>
	</div>
	<hr />

	<ul class="subTab01">
		<li class="on1"><a href="#">캠페인 정보</a></li>
		<li><a href="#">광고 정보</a></li>
	</ul>

	<h4 class="floatL">캠페인 정보</h4>
	<div class="floatR">
		<a href="javascript:location.replace('/campaign/campaign/edit?campaign_sq=<?php echo $campaign_vo->get_campaign_sq();?>');"><img src="/web/images/button/btn_campaign_edit.gif" alt="캠페인 정보 수정" /></a>
	</div>

	<table class="boardDataType mg_t10" summary="캠페인 상세페이지">
		<colgroup>
			<col width="15%" />
			<col width="35%" />
			<col width="15%" />
			<col width="35%" />
		</colgroup>
		<tr>
			<th>캠페인 명</th>
			<td class="WriteLft end" colspan="3"><?php echo $campaign_vo->get_campaign_nm();?></td>
		</tr>
		<tr>
			<th>캠페인 설명</th>
			<td class="WriteLft end" colspan="3"><?php echo $campaign_vo->get_campaign_desc();?></td>
			<tr>
				<th>광고주</th>
				<td class="WriteLft end"><?php echo $campaign_vo->get_adv_company_nm();?></td>
				<th>브랜드</th>
				<td class="WriteLft end"><?php echo $campaign_vo->get_adv_brand_nm();?></td>
			</tr>
			<tr>
				<th>Report ID</th>
				<td class="WriteLft end"><?php echo $campaign_vo->get_report_id();?></td>
				<th>Report PW</th>
				<td class="WriteLft end"><?php echo '';//$campaign_vo->get_report_password();?></td>
			</tr>
	</table>
	<p class="mg_t10">
		<a href="javascript:campaignHistory(<?php echo $campaign_vo->get_campaign_sq();?>);"><img src="/web/images/button/btn_history_120727.gif" alt="캠페인 history" /></a>
	</p>

	<h4>광고 리스트</h4>
	<table class="compaingTable" summary="캠페인 리스트">
		<colgroup>
			<col width="5%" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
		</colgroup>
		<thead>
			<tr>
				<th class="first"></th>
				<th>No</th>
				<th>광고 명</th>
				<th>광고주</th>
				<th>브랜드</th>
				<th>목표건수</th>
				<th>발송건수</th>
				<th>발송일자</th>
				<th>상태</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="9">등록된 광고가 없습니다.</td>
				</tr>
			<?php else: ?>
				<?php foreach($list as $advert_vo): ?>
					<tr>
						<td>
							<input type="hidden" id="ad_status_cd_<?php echo $advert_vo->get_ad_sq();?>" value="<?php echo $advert_vo->get_ad_status_cd();?>" />
							<input type="radio" name="ad_sq" id="ad_sq_<?php echo $advert_vo->get_ad_sq();?>" value="<?php echo $advert_vo->get_ad_sq();?>" <?php echo $advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_send') || $advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_com') ? 'disabled' : '';?> />
						</td>
						<td><?php echo $advert_vo->get_ad_sq();?></td>
						<td><a href="javascript:location.replace('/campaign/advert/detail?list_type=campaign&ad_sq=<?php echo $advert_vo->get_ad_sq();?>');"><?php echo $advert_vo->get_ad_nm() ?></a></td>
						<td><?php echo $campaign_vo->get_adv_company_nm();?></td>
						<td><?php echo $campaign_vo->get_adv_brand_nm();?></td>
						<td><?php echo $advert_vo->get_push_booking_cnt();?></td>
						<td><?php echo $advert_vo->get_request_cnt();?></td>
						<?php if($this->config->item('ad_start_dt_edit') === TRUE):?>
							<?php if($advert_vo->get_ad_status_cd() == $this->lang->line('ad_status_stand') && $advert_vo->get_sch_status_cd() == $this->lang->line('sch_status_file_com')):?>
								<td>
									<a href="javascript:location.replace('<?php echo sprintf('/test/test/advertBookingDateEdit?campaign_nm=%s&campaign_sq=%s&ad_nm=%s&ad_sq=%s&start_dt=%s', $advert_vo->get_campaign_nm(), $advert_vo->get_campaign_sq(), $advert_vo->get_ad_nm(), $advert_vo->get_ad_sq(), $advert_vo->get_start_dt());?>');">
										<?php echo $advert_vo->get_start_dt();?>
									</a>
								</td>
							<?php else:?>
								<td><?php echo $advert_vo->get_start_dt();?></td>
							<?php endif;?>
						<?php else:?>
							<td><?php echo $advert_vo->get_start_dt();?></td>
						<?php endif;?>
						<td><?php echo $advert_vo->get_ad_status_nm();?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="mgT10">
		<p class="floatL">
			<span class="inventoryText">선택 항목</span>
			<select class="mg_r10" id="execute_type" name="execute_type">
				<option value="">선택</option>
				<option value="<?php echo $this->lang->line('ad_status_stand');?>">발송</option>
				<option value="<?php echo $this->lang->line('ad_status_test');?>">취소</option>
			</select>
			<a href="javascript:execute();"><img src="/web/images/button/btn_action.gif" alt="실행" /> </a>
		</p>
	</div>

	<div class="btnListArea">
		<p class="floatR">
			<a href="javascript:location.replace('/campaign/advert/write?campaign_sq=<?php echo $campaign_vo->get_campaign_sq();?>');"><img src="/web/images/button/reg.gif" alt="등록" /> </a>
		</p>
	</div>
</div>
<!-- //content-->
