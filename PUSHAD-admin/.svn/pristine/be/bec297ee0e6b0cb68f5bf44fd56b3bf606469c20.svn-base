<!--컨텐츠 -->
<div id="content">
	<form id="list_form" name="list_form">
		<input type="text" style="width:0;visibility:hidden;">
		<div class="subTitleArea">
			<h3>동의 현황 조회</h3>
		</div>
	
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_search">
				<strong class="title">MDN 입력</strong>
				<input type="hidden" id="search_result" value="<?php echo $agreement_vo->get_mdn() != '' ? 'true' : 'false';?>" />
				<input type="text" id="mdn" name="mdn" class="textType mg_l10" title="검색어 입력" value="<?php echo $mdn;?>" />
				<a href="javascript:search();">
					<img id="BTN_SEARCH" src="/web/images/button/search.gif" alt="검색" />
				</a>
			</div>
		</div>
		<!--// 검색 -->
	
		<?php if(!empty($agreement_vo)):?>
			<input type="hidden" id="device_id" value="<?php echo $agreement_vo->get_device_id();?>" />
			<input type="hidden" id="carrier" value="<?php echo $agreement_vo->get_carrier();?>" />
			<input type="hidden" id="media_id" value="<?php echo $agreement_vo->get_media_id();?>" />
			
			<h4>동의 상세 정보</h4>
			<table class="boardDataType" summary="동의 상세 정보">
			<colgroup>
				<col width="20%" />
				<col width="30%" />
				<col width="10%" />
				<col width="10%" />
				<col width="30%" />
			</colgroup>
			<tr>
				<th>MDN</th>
				<td><?php echo $agreement_vo->get_mdn(); ?></td>
				
				<th colspan="2">동의 상태</th>
				<td class="end">
					<?php echo $agreement_vo->get_agreement_nm();?>
					<?php if($agreement_vo->get_terms_bit() >= '8' and $agreement_vo->get_terms_bit() <= '15'):?>
						<a href="javascript:mdn_recant('<?php echo $agreement_vo->get_mdn();?>');">
							<img id="agree_cancel" src="/web/images/button/btn_recant.gif" alt="철회하기" />
						</a>
					<?php endif;?>
					</a>
				</td>
			</tr>
			
			<tr>
				<th>Device ID</th>
				<td><?php echo $agreement_vo->get_device_id(); ?></td>
				
				<th colspan="2">최근 상태 변경 일시</th>
				<td class="end"><?php echo $agreement_vo->get_log_dt();?></td>
			</tr>
			
			<tr>
				<th>이통사</th>
				<td><?php echo $agreement_vo->get_carrier_nm(); ?></td>
				
				<th colspan="2">최근 동의 약관 Ver.</th>
				<td class="end"><?php echo $agreement_vo->get_provision_ver();?></td>
			</tr>
			
			<?php if($agreement_vo->get_terms_bit() >= '8' and $agreement_vo->get_terms_bit() <= '15'):?>
				<tr>
					<th rowspan="2">가입 채널</th>
					<td rowspan="2">Push AD</td>
					<th rowspan="2">최근 동의</th>
	
					<th>App 명칭</th>
					<td class="end"><?php echo $agreement_vo->get_media_nm();?> </td>
				</tr>
				
				<tr>
					<th>App ID</th>
					<td class="end"><?php echo $agreement_vo->get_media_id();?></td>
				</tr>
			<?php else:?>
				<tr>
					<th rowspan="2">가입 채널</th>
					<td rowspan="2">Push AD</td>
					<th rowspan="2">최근 철회</th>
					
					<th>철회 경로</th>
					<td class="end">
					<?php if($agreement_vo->get_path_nm() != ''):?>
						<?php echo $agreement_vo->get_path_nm();?>
					<?php else: ?>
						<?php echo $agreement_vo->get_media_nm();?>
					<?php endif;?> 
					</td>
				</tr>
				
				<tr>
					<th>철회 접수자</th>
					<td class="end">
					<?php if($agreement_vo->get_path_nm() != ''):?>
						<?php echo $agreement_vo->get_user_id();?>
					<?php else: ?>
						<?php echo "본인";?>
					<?php endif; ?> 	
					</td>
				</tr>
			<?php endif;?>
			</table>
		<?php endif; ?>
	</form>
</div>
<!-- //content-->