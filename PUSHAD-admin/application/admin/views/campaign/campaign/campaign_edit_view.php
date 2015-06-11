<!--컨텐츠 -->
<div id="content">
	<form id="write_form" name="write_form">
		<div class="subTitleArea">
			<h3>Cross-marketing 캠페인 리스트</h3>
		</div>
		<hr />
	
		<ul class="subTab01">
			<li class="on1"><a href="#">캠페인 정보</a></li>
			<li><a href="#">광고 정보</a></li>
		</ul>
	
		<table class="boardDataType mg_t10" summary="캠페인 정보 상세 수정">
			<colgroup>
				<col width="13%" />
				<col width="37%" />
				<col width="13%" />
				<col width="37%" />
			</colgroup>
			<tbody>
				<tr>
					<th>캠페인 명 <strong class="important">*</strong></th>
					<td class="WriteLft end" colspan="3">
						<input type="hidden" id="campaign_sq" name="campaign_sq" value="<?php echo $campaign_vo->get_campaign_sq();?>" />
						<input type="text" id="campaign_nm" name="campaign_nm" style="width: 80%;" value="<?php echo $campaign_vo->get_campaign_nm();?>"/>
						<span id="campaign_nm_validate"><strong class="counting">0</strong> / 80자</span>
					</td>
				</tr>
				<tr>
					<th>캠페인 설명</th>
					<td class="WriteLft end" colspan="3">
						<input type="text" id="campaign_desc" name="campaign_desc" style="width: 80%;" value="<?php echo $campaign_vo->get_campaign_desc();?>" />
						<span id="campaign_desc_validate"><strong class="counting">0</strong> / 80자</span>
					</td>
				</tr>
				<tr>
					<th>광고주 <strong class="important">*</strong></th>
					<td class="WriteLft end">
						<input type="text" id="adv_company_nm" name="adv_company_nm" style="width: 70%;" value="<?php echo $campaign_vo->get_adv_company_nm();?>" />
						<input type="hidden" id="adv_company_sq" name="adv_company_sq" value="<?php echo $campaign_vo->get_adv_company_sq();?>" />
					</td>
					<th>브랜드 <strong class="important">*</strong></th>
					<td class="WriteLft end">
						<!-- 
						<input type="hidden" id="adv_account_sq" name="adv_account_sq" />
						 -->
						<input type="hidden" id="adv_brand_nm" name="adv_brand_nm" value="<?php echo $campaign_vo->get_adv_brand_nm();?>" />
						<span id="brand_selectbox_layer">
							<?php echo $adv_brand_selectbox;?>
						</span>
					</td>
				</tr>
				<tr>
					<th>Report ID</th>
					<td class="WriteLft end"><?php echo $campaign_vo->get_report_id();?></td>
					<th>Report PW <strong class="important">*</strong></th>
					<td class="WriteLft end">
						<input type="password" id="report_password" name="report_password" value="<?php echo '';//$campaign_vo->get_report_password();?>"/>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="btnC">
			<span><a href="javascript:campaign_edit();"><img src="/web/images/button/btn_modify.gif" alt="수정" /></a></span>
			<span><a href="javascript:campaign_cancel();"><img src="/web/images/button/cancel03.gif" alt="취소" /></a> </span>
		</div>
	</form>
</div>
<!-- //content-->
