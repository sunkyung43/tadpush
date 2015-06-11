<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>T ad Push</title>
<link rel="stylesheet" type="text/css" media="all" href="../../web/css/popup_v2.css" />
<link rel="stylesheet" type="text/css" media="all" href="../../web/css/board_v2.css" />
<script type="text/javascript" src="../../web/js/common.js"></script>
<script type="text/javascript" src="../../web/js/expression.js"></script>
<script type="text/javascript" src="../../web/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../../web/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../web/js/jquery.form.js"></script>
</head>
<body>
<div id="popTop">
  <h2>정보변경 이력<a href="#" class="closePopup" onclick="window.close();"><img src="../../web/images/button/close_popup.gif" alt="창 닫기" /></a></h2>
</div>
<div class="popWrapper">
	<table class="compaingTable">
	<colgroup>
	<col width="30%" />
	<col width="15%" />
	<col width="15%" />
	<col width="20%" />
	<col width="20%" />
	</colgroup>
		<thead>
			<tr>
				<th class="first">변경 일시</th>
				<th>작업자</th>
				<th>변경항목</th>
				<th>이전 값</th>
				<th>변경 값</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($list) || empty($list)): ?>
				<tr>
					<td colspan="5">정보변경 내역이 없습니다.</td>
				</tr>
			<?php else: ?>
			<?php foreach($list as $row): ?>
			<tr>
				<td><?php echo $row['division_dt'];?></td>
				<td><?php echo $row['account_id'];?></td>
				<td><?php echo $row['history_gb'];?></td>
				<td><?php echo $row['modify_before'];?></td>
				<td><?php echo $row['modify_after'];?></td>
			</tr>
			<?php endforeach;?>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>
</div>
<div class="alignC mg_t20"><a href="javascript:window.close();"><img src="../../web/images/button/close.gif" alt="닫기" /></a></div>
</body>
</html>
