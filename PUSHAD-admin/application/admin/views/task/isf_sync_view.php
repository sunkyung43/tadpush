<!--컨텐츠 -->
<div id="content">
	<div class="subTitleArea">
		<h3>ISF 연동</h3>
	</div>

	<form id="write_form" name="write_form">
		<table class="boardDataType" summary="모수 Sync">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<tr>
				<th colspan="2" style="text-align: center">ISF 전체 데이터 Sync</th>
			</tr>
			<tr>
				<th>* Interface</th>
				<td class="end">
					<select id="isf_sync_interface" name="isf_sync_interface" style="width:200px;">
						<option value="param">/meta/param</option>
						<option value="param_media">/meta/param_media</option>
						<option value="media">/meta/media</option>
						<option value="frequency">/meta/frequency</option>
						<option value="ad">/meta/ad</option>
						<option value="campaign">/meta/campaign</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>요 청</th>
				<td class="end">
					<a href="javascript:isf_sync();">
						<img src="/web/images/button/send.gif" alt="ISF 요청" />
					</a>
				</td>
			</tr>
		</table>
		
		<table class="boardDataType" summary="ISF 요청">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<tr>
				<th colspan="2" style="text-align: center">ISF 요청</th>
			</tr>
			<tr>
				<th>* Interface</th>
				<td class="end">
					<select id="isf_request_interface" name="isf_request_interface" onchange="javascript:changeInterface();" style="width:200px;">
						<option value="param">/meta/param</option>
						<option value="param_media">/meta/param_media</option>
						<option value="media">/meta/media</option>
						<option value="frequency">/meta/frequency</option>
						<option value="ad">/meta/ad</option>
						<option value="campaign">/meta/campaign</option>
						<option value="count">/target/param/count</option>
						<option value="reserve">/target/param/reserve</option>
						<option value="down">/target/param/down</option>
						<option value="cancel">/target/ad/cancel</option>
						<option value="status">/target/ad/status</option>
						<option value="report">/report/ad</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>* Method</th>
				<td class="end">
					<select id="isf_method" name="isf_method" style="width:200px;">
						<option value="GET">GET</option>
						<option value="POST">POST</option>
						<option value="PUT">PUT</option>
						<option value="DELETE">DELETE</option>
					</select>
				</td>
			</tr>
			<tr id="device_id_layer" class="parameterLayer">
				<th>* Device ID</th>
				<td class="end">
					<input type="text" id="device_id" name="device_id" class="textType" />
				</td>
			</tr>
			<tr id="media_id_layer" class="parameterLayer">
				<th>* Media ID</th>
				<td class="end">
					<input type="text" id="media_id" name="media_id" class="textType" />
				</td>
			</tr>
			<tr id="frequency_sq_layer" class="parameterLayer">
				<th>* Frequency SQ</th>
				<td class="end">
					<input type="text" id="frequency_sq" name="frequency_sq" class="textType" />
				</td>
			</tr>
			<tr id="ad_sq_layer" class="parameterLayer">
				<th>* AD SQ</th>
				<td class="end">
					<input type="text" id="ad_sq" name="ad_sq" class="textType" />
				</td>
			</tr>
			<tr id="campaign_sq_layer" class="parameterLayer">
				<th>* Campaign SQ</th>
				<td class="end">
					<input type="text" id="campaign_sq" name="campaign_sq" class="textType" />
				</td>
			</tr>
			<tr>
				<th>요 청</th>
				<td class="end">
					<a href="javascript:isf_request();">
						<img src="/web/images/button/send.gif" alt="ISF 요청" />
					</a>
				</td>
			</tr>
		</table>
		
		<table class="boardDataType" summary="ISF 응답">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<tr>
				<th colspan="2" style="text-align: center">요청 결과</th>
			</tr>
			<tr>
				<th>Response</th>
				<td class="end">
					<textarea id="isf_response" rows="10" cols="10" style="width:100%; resize:none;"></textarea>
				</td>
			</tr>
		</table>		
		
	</form>

</div>
<!-- //content-->
