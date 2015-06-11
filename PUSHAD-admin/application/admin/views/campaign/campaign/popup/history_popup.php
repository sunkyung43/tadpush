<div id="popTop">
	<h2>
		캠페인 history
		<a href="#" class="closePopup" onclick="window.close();" style="line-height:0px;">
			<img src="/web/images/button/close_popup.gif" alt="창 닫기" />
		</a>
	</h2>
</div>
<div class="popWrapper">
	<form id="list_form" name="list_form">
		<input type="hidden" id="campaign_sq" name="campaign_sq" value="<?php echo $campaign_sq;?>" />
		<div>항목 선택 
			<?php echo $list_type_selectbox;?>
		</div>
	
		<table class="boardDataType mg_t10 txtC">
			<colgroup>
				<col width="5%" />
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
					<th class="first">No</th>
					<th>대상</th>
					<th>항목</th>
					<th>이전내용</th>
					<th>변경내용</th>
					<th>작업자</th>
					<th>작업일시</th>
					<th class="end">수정 사유</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!isset($list) || empty($list)): ?>
					<tr>
						<td colspan="8">검색결과가 없습니다.</td>
					</tr>
				<?php else: ?>
					<?php foreach($list as $history_vo): ?>
						<tr>
							<td><?php echo $history_vo->get_campaign_history_sq();?></td>
							<?php if($history_vo->get_ad_nm() != ''):?>
								<td><?php echo $history_vo->get_ad_nm();?></td>
							<?php else:?>
								<td>캠페인</td>
							<?php endif?>
							<td><?php echo $history_vo->get_history_gb();?></td>
							<td><?php echo $history_vo->get_modify_before();?></td>
							<td><?php echo $history_vo->get_modify_after();?></td>
							<td><?php echo $history_vo->get_user_nm();?>(<?php echo $history_vo->get_account_sq();?>)</td>
							<td><?php echo $history_vo->get_create_dt();?></td>
							<td class="end">
								<input type="text" style="width: 80%;" class="input_comment" id="history_comment_<?php echo $history_vo->get_campaign_history_sq();?>" value="<?php echo $history_vo->get_history_comment();?>"/>
								<input type="hidden" id="history_comment_<?php echo $history_vo->get_campaign_history_sq();?>_org" value="<?php echo $history_vo->get_history_comment();?>"/>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	
		<?php echo $paging;?>
	</form>
</div>
<div class="alignC">
	<a href="#" onclick="window.close();">
		<img src="/web/images/button/close.gif" alt="닫기" />
	</a>
</div>