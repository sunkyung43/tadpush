<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>약관 관리</h3>
	</div>

	<h4><span align='right'>ver <?php echo $data['provision_ver'];?> ( <?php echo $data['create_dt'];?> ) </span></h4>
		<table class="boardDataType" summary="개인정보 활용동의 약관/위치정보 활용동의 약관">
			<thead>
				<tr>
					<th class="textCenter end"><b>개인정보 제공동의</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="WriteLft end">
						<div id="context_private" style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $data['person_offer_content']?></pre>
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
						<div id="context_location" style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $data['person_gather_content'];?></pre>
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
						<div id="context_location" style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $data['location_cather_content'];?></pre>
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
						<div id="context_location" style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $data['ad_receive_content'];?></pre>
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
						<div id="context_location" style="overflow: auto; height: 120px; border: solid 1px #CCCED7">
							<pre><?php echo $data['policy_content'];?></pre>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	<div class="btnC clear">
		<a href="javascript:location.replace('/system/provisionSupervise');"><img src="/web/images/button/btn_list.gif" alt="목록" /> </a>
	</div>
</div>
<!-- //content-->