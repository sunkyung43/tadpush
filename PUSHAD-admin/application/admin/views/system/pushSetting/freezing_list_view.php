<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>Freezing 관리</h3>
	</div>

	<table class="compaingTable" summary="">
		<colgroup>
			<col width="40%" />
			<col width="30%" />
			<col width="30%" />
		</colgroup>
		<tr>
			<th class="first">시간</th>
			<th>수정일</th>
			<th class="end">등록일</th>
		</tr>

		<?php if (!isset($freezing) || empty($freezing)): ?>
			<tr>
				<td colspan="3">등록된 Freezing이 없습니다.</td>
			</tr>
		<?php else: ?>
			<tr>
				<td><?php echo $freezing['apply_time'];?>분</td>
				<td><?php echo $freezing['update_dt']; ?></td>
				<td><?php echo $freezing['create_dt']; ?></td>
			</tr>
		<?php endif; ?>		
	</table>

	<ul class="ulList">
		<li>
			<span class="blt">※</span>
			 ISF 플랫폼 설정 값을 표시합니다.
		</li>
	</ul>
	
</div>
<!-- //content-->
