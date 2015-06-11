<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>약관 관리</h3>
	</div>

	<table class="boardDataType02" summary="약관 관리">
		<colgroup>
			<col width="10%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
		</colgroup>
		<tr>
			<th>약관 Ver.</th>
			<th>약관 적용일자</th>
			<th>모두 동의자 수</th>
			<th>일부 동의자 수</th>
			<th>현상태</th>
			<th class="end">약관 세부내역 보기</th>
		</tr>
		<tbody>
			<?php if (empty($list)): ?>
				<tr>
					<td colspan="6">등록된 약관이 없습니다.</td>
				</tr>
			<?php else: ?>
				<?php foreach($list as $row): ?>
					<tr>
						<td><?php echo $row['provision_ver'];?></td>
						<td><?php echo $row['create_dt'];?></td>
						<td><?php echo $row['terms_yy'];?>
						</td>
						<td><?php echo $row['terms_yn'];?> <!-- 512,421 --></td>
						<td><?php echo $row['provision_status_nm'];?></td>
						<td class="end">
							<a href="javascript:location.replace('/system/provisionSupervise/detail?provision_sq=<?php echo $row['provision_sq'];?>');">
								<img src="/web/images/button/btn_provView.gif" alt="약관 보기" />
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>

	</table>

	<div class="btnListArea">
		<p class="floatR">
			<a href="javascript:location.replace('/system/provisionSupervise/write');">
				<img src="/web/images/button/btn_newPrivacy.gif" alt="신규약관등록" />
			</a>
		</p>
	</div>

	<?php if(!empty($provision)):?>
		<h4>
			현 약관 버전 : ver <?php echo $provision['provision_ver'];?> ( <?php echo $provision['create_dt'];?> )
		</h4>
		<table class="boardDataType" summary="개인정보 활용동의 약관/위치정보 활용동의 약관">
			<thead>
				<tr>
					<th class="textCenter end"><b>개인정보 제공동의</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end">
						<div id="context_private"
							style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $provision['person_offer_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th class="textCenter end"><b>개인정보 수집/이용 동의</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end end">
						<div id="context_location"
							style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $provision['person_gather_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th class="textCenter end"><b>약관 및 개인위치정보 수집/이용</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end">
						<div id="context_location"
							style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $provision['location_cather_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th class="textCenter end"><b>정보/광고 수신동의</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end">
						<div id="context_location"
							style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $provision['ad_receive_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th class="textCenter end"><b>개인정보 취급방침</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end">
						<div id="context_location"
							style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $provision['policy_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	<?php endif;?>

</div>
<!-- //content-->
