<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>Frequency 관리</h3>
	</div>

	<table class="compaingTable" summary="">
		<colgroup>
			<col width="10%" />
			<col width="30%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
		</colgroup>
		<tr>
			<th class="first">No</th>
			<th>적용 기간</th>
			<th>주기</th>
			<th>Frequency 수</th>
			<th>상태</th>
			<th class="end">등록일</th>
		</tr>

		<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="6">등록된 Frequency가 없습니다.</td>
			</tr>
		<?php else: ?>
			<?php foreach($list as $frequency_vo): ?>
			<?php if($frequency_vo->get_frequency_status_nm() == '진행'):?>
			<tr style="background:#fde337;">
			<?php else:?>
			<tr>
			<?php endif;?>
				<td><?php echo $frequency_vo->get_frequency_sq();?></td>
				<td><?php echo $frequency_vo->get_start_end_dt(); ?></td>
				<td><?php echo $frequency_vo->get_cycle(); ?></td>
				<td><?php echo $frequency_vo->get_frequency_cnt(); ?></td>
				<td><?php echo $frequency_vo->get_frequency_status_nm(); ?></td>
				<td><?php echo $frequency_vo->get_create_dt(); ?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>		
	</table>

	<?php echo '';//$paging;?>
	
	<div class="btnListArea">
		<p class="floatR">
			<a href="javascript:location.replace('/system/pushSetting/write');">
				<img src="/web/images/button/reg.gif" alt="등록" />
			</a>
		</p>
	</div>

</div>
<!-- //content-->
