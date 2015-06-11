<?php if(isset($err_msg)):?>
	<script type="text/javascript">
	$(document).ready(function() {
		alert('<?php echo $err_msg;?>');
		window.close();
	});
	
	</script>
<?php else:?>
	<div id="popTop">
		<h2>
			조회 
			<a href="#" class="closePopup" onclick="window.close();" style="line-height:0px;"> 
				<img src="/web/images/button/close_popup.gif" alt="창 닫기" />
			</a>
		</h2>
	</div>
	<div class="popWrapper">
		<p class="popTitle">
			* 설정한 조건으로 <strong><?php echo number_format($COUNT);?></strong>건 발송
			가능하며, 세부 현황은 아래와 같습니다.
		</p>
		<div class="scrollArea">
			<?php if(!empty($GENDER_AGE_COUNT)):?>
				<p class="title">성별</p>
				<table class="boardDataType tblCenter" summary="캠페인 리스트">
					<colgroup>
						<col width="">
						<col width="">
					</colgroup>
					<thead>
						<tr>
							<th>남자</th>
							<th class="end">여자</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo number_format($GENDER_M_COUNT);?></td>
							<td class="end"><?php echo number_format($GENDER_F_COUNT);?></td>
						</tr>
					</tbody>
				</table>
			<?php endif;?>
				
			<?php if(!empty($GENDER_AGE_COUNT)):?>
				<p class="title">성별 & 나이</p>
				<table class="boardDataType tblCenter">
					<colgroup>
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
					</colgroup>
					<thead>
						<tr>
							<th colspan="2">남자</th>
							<th colspan="2" class="end">여자</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($GENDER_AGE_COUNT as $age => $age_array):?>
							<tr>
								<th><?php echo $age_array['M']['TITLE'];?></th>
								<td><?php echo number_format($age_array['M']['COUNT']);?></td>
								<th><?php echo $age_array['M']['TITLE'];?></th>
								<td class="end"><?php echo number_format($age_array['F']['COUNT']);?></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			<?php endif;?>
		
			<?php if(!empty($ADDR_COUNT)):?>
				<p class="title">지역별</p>
				<table class="boardDataType tblCenter">
					<colgroup>
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
					</colgroup>
					<tbody>
						<?php $index = 0;?>
						<?php foreach($ADDR_COUNT as $array):?>
							<?php if($index % 2 == 0):?>
								<tr>
									<th><?php echo $array['TITLE'];?></th>
									<td><?php echo number_format($array['COUNT']);?></td>
							<?php else:?>
									<th><?php echo $array['TITLE'];?></th>
									<td class="end"><?php echo number_format($array['COUNT']);?></td>
								</tr>
							<?php endif;?>
							<?php $index++;?>
						<?php endforeach;?>
						<?php if($index % 2 != 0):?>
								<th></th>
								<td class="end"></td>
							</tr>
						<?php endif;?>
					</tbody>
				</table>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>
