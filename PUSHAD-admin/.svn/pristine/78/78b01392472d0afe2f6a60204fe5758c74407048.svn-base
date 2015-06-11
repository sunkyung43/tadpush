<script type="text/javascript">
$(document).ready(function() {
	addDynatree('target_os_tree', <?php echo $target_os_list;?>, 'os_ver');
	addDynatree('target_device_tree', <?php echo $target_device_list;?>, 'model_nm');
	addDynatree('target_media_group_tree', <?php echo $target_media_group_list;?>, 'media_group_cd');
	addDynatree('target_media_category_tree', <?php echo $target_media_category_list;?>, 'media_category_cd');
	addDynatree('target_carrier_tree', <?php echo $target_carrier_list;?>, 'carrier_cd');
	addDynatree('target_gender_tree', <?php echo $target_gender_list;?>, 'gender_cd');
	addDynatree('target_age_tree', <?php echo $target_age_list;?>, 'age_rng_cd');

	init();
});
</script>

<!--컨텐츠 -->
<div id="content">
	<form id="write_form" name="write_form">
		<input type="hidden" id="ad_sq" name="ad_sq" value="<?php echo $advert_vo->get_ad_sq();?>" />
		<input type="hidden" id="ad_status_cd" name="ad_status_cd" value="<?php echo $advert_vo->get_ad_status_cd();?>" />
		<input type="hidden" id="freezing" name="freezing" value="<?php echo $advert_vo->get_freezing();?>" />
		<input type="hidden" id="list_type" name="list_type" value="<?php echo $list_type;?>" />
		<div class="subTitleArea">
			<h3>Cross-marketing 캠페인 리스트</h3>
		</div>
		<hr />

		<ul class="subTab01">
			<li><a href="#">캠페인 정보</a></li>
			<li class="on1"><a href="#">광고 정보</a></li>
		</ul>

		<h4>캠페인 정보</h4>
		<table class="boardDataType mg_t10" summary="캠페인 정보 상세">
			<colgroup>
				<col width="26%" />
				<col width="" />
			</colgroup>
			<tbody>
				<tr>
					<th>캠페인 명</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_campaign_nm();?></td>
					<th>광고주</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_adv_company_nm();?></td>
				</tr>
				<tr>
					<th>캠페인 설명</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_campaign_desc();?></td>
					<th>브랜드</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_adv_brand_nm();?></td>
				</tr>
			</tbody>
		</table>

		<h4>광고 정보</h4>
		<span id="ad_table">
			<table class="boardDataType mg_t10" summary="광고 정보 상세">
				<colgroup>
					<col width="13%" />
					<col width="37%" />
					<col width="13%" />
					<col width="37%" />
				</colgroup>
				<tbody>
					<tr>
						<th>광고 명 <strong class="important">*</strong></th>
						<td class="WriteLft end" colspan="3">
							<input type="text" id="ad_nm" name="ad_nm" style="width: 80%;" value="<?php echo $advert_vo->get_ad_nm();?>" />
							<span id="ad_nm_validate"><strong class="counting">0</strong> / 80자</span>
					</tr>
					<tr>
						<th>발송 건수 <strong class="important">*</strong></th>
						<td class="WriteLft end">
							<input type="text" id="push_booking_cnt" name="push_booking_cnt" style="width: 70px;" value="<?php echo $advert_vo->get_push_booking_cnt();?>" />
						<th>발송 일자 <strong class="important">*</strong></th>
						<td class="WriteLft end">
							<input type="hidden" id="calendar_min_day" value="<?php echo $calendar_min_day;?>" />
							<input type="hidden" id="calendar_max_week" value="<?php echo $calendar_max_week;?>" />
						<input id="start_dt" name="start_dt" class="textType" style="width: 70px;" title="조회 시작일 입력" type="text" value="<?php echo $advert_vo->get_start_date();?>" />
						</td>
					</tr>
					<tr>
						<th>발송 시간 <strong class="important">*</strong></th>
						<td class="WriteLft end" colspan="3">
							<span id="time_selectbox_layer">
								<?php echo $time_selectbox;?>
							</span>
						</td>
					</tr>
				</tbody>
			</table>
		</span>

		<h4>소재 정보</h4>
		<span id="creative_table">
			<?php echo $creative_selectbox;?>
			
			<span id="creative_test_layer" <?php echo $advert_vo->get_creative_type_cd() == '' || $advert_vo->get_creative_sq() == '' ? 'style="display: none;"' : ''?>>
				<a href="javascript:creativeTest();"><img src="/web/images/button/btnTest.gif" alt="테스트" /></a>
			</span>
			
			<span id="creative_layer">
				<!-- [D] 하기 주석으로 그룹핑된 소재정보는 상기 소재정보 옵션 선택에 따른 입력테이블입니다. -->
				<?php if($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_text')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_text_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_image')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_image_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_popup_text_banner')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_popup_text_banner_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_popup_text')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_popup_text_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_popup_image_banner')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_popup_image_banner_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_popup_image')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_popup_image_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_jb_default')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_jb_default_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_jb_big_text')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_jb_big_text_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_jb_inbox')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_jb_inbox_layer', $this, true);?>
				<?php elseif($advert_vo->get_creative_type_cd() == $this->lang->line('creative_type_jb_big_picture')):?>
					<?php echo $this->load->view('campaign/advert/creative/creative_jb_big_picture_layer', $this, true);?>
				<?php endif;?>
			</span>
		</span>
		
		<h4>타게팅 정보</h4>
		<span id="target_table">
			<!-- [D] 하기 모든 타게팅 그룹의 해제 선택 화면 표현은 'targetSet_on' 클래스 삭제 및 'targetSet_view' 클래스 숨김처리하시면 됩니다. -->
			<?php echo $this->load->view('campaign/advert/target/target_os_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_device_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_media_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_carrier_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_gender_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_age_layer', $this, true);?>
			<?php echo $this->load->view('campaign/advert/target/target_region_layer', $this, true);?>
		</span>

		<div class="btnC">
			<span id="edit_btn"><a href="javascript:advert_edit();"><img src="/web/images/button/btn_modify.gif" alt="수정" /></a></span>
			<span><a href="javascript:location.replace('<?php echo $list_url;?>');"><img src="/web/images/button/btn_publisher_list.gif" alt="목록" /></a></span>
		</div>
	</form>
</div>
<!-- //content-->