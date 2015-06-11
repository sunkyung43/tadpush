<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>발송 동의 현황</h3>
	</div>

	<h4>T ad Push 사용자 발송 동의 현황</h4>
	<table class="boardDataType02" summary="T ad Push 사용자 발송 동의 현황">
		<colgroup>
			<col width="25%" />
			<col width="75%" />
		</colgroup>
		<tr>
			<th rowspan="2">구분</th>
			<th class="end">T ad Push 발송 동의자</th>
		</tr>
		<tr>
			<th class="end">현재 가용 동의자</th>
		</tr>
		<tr>
			<td>대상인원</td>
			<td class="end"><?php ECHO number_format($total_param_count)?></td>
		</tr>
		<?php foreach($list as $carrier_nm => $row):?>
			<tr>
				<td><?php echo $carrier_nm;?></td>
				<td class="end"><?php ECHO number_format($row['param_cnt']) ?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>
<!-- //content-->