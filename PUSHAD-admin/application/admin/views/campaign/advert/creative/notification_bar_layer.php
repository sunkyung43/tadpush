	<h5 class="materialTit">※ Notification Bar</h5>
	<table class="boardDataType" summary="소재 설정">
		<colgroup>
			<col width="15%" />
			<col width="" />
		</colgroup>
		<tr>
			<th>Ticket Text <strong class="important">*</strong></th>
			<td class="WriteLft end">
				<input type="text" id="ticket_text" name="ticket_text" value="<?php echo $creative_vo->get_ticket_text();?>" style="width: 40%" />
				 (권장 23자, 최대 45자)
			</td>
		</tr>
	</table>