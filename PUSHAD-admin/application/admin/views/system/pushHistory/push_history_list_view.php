<!--컨텐츠 -->
<div id="content">
	<form id="list_form" name="list_form">
		<input type="text" style="width:0;visibility:hidden;">
		<div class="subTitleArea">
			<h3>발송 이력 조회</h3>
		</div>
		
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_search">
				<strong class="title">MDN 입력</strong>
				<input type="text" id="mdn" name="mdn" class="textType mg_l10" title="검색어 입력" value="<?php echo $mdn;?>" />
				<a href="javascript:search();">
					<img id="btn_search" src="/web/images/button/search.gif" alt="검색" />
				</a>
			</div>
		</div>
		<!--// 검색 -->
		
		<?php if(1) :?>
			<!-- 검색결과 영역 -->
			<h4>최근 발송 이력</h4>
			
			<?php if(isset($excel_url)):?>
				<p class="textRight mg_b10">
					<a href="<?php echo $excel_url;?>">
						<img src="/web/images/button/excel_btn33.png" alt="엑셀 다운로드" />
					</a>
				</p>
			<?php endif;?>
			
			<table class="compaingTable" summary="사용자 별 발송 이력 조회 리포트">
				<colgroup>
					<col width="5%" />
					<col width="10%" />
					<col width="10%" />
					<col width="13%" />
					<col width="13%" />
					<col width="12%" />
					<col width="10%" />
					<col width="7%" />
				</colgroup>
				<tr>
					<th class="first">No</th>
					<th>MDN</th>
					<th>Device ID</th>
					<th>발송일/시간</th>
					<th>캠페인 명</th>
					<th>AD 명</th>
					<th>App 명</th>
					<th class="end">상태</th>
				</tr>
				<?php if(!isset($list)) :?>
				
				<?php elseif(empty($list)) :?>
					<tr>
						<td colspan="8">검색결과가 없습니다.</td>
					</tr>
				<?php else:?>
	    			<?php foreach($list as $push_history_vo): ?>
				    	<tr>
							<td><?php echo $push_history_vo->get_row_num(); ?></td>
							<td class="textLeft"><?php echo $push_history_vo->get_mdn(); ?></td>
							<td><?php echo $push_history_vo->get_device_id(); ?></td>
							<td><?php echo $push_history_vo->get_start_dt(); ?></td>
							<td><?php echo $push_history_vo->get_campaign_nm(); ?></td>
							<td><?php echo $push_history_vo->get_ad_nm(); ?></td>
							<td><?php echo $push_history_vo->get_media_nm(); ?></td>
							<td><?php echo $push_history_vo->get_success_yn(); ?></td>
						</tr>
	    			<?php endforeach; ?>
	    		<?php endif;?>
	  		</table>
	  		
	  		<?php echo isset($paging) ? $paging : ''; ?>
	  		
	  	<?php endif;?>
	</form>
</div>
<!-- //content-->