<div id="content">
	<div class="subTitleArea">
		<h3>미디어</h3>
	</div>

	<!-- 검색 //-->
	<form id="search_form" name="search_form">
	<div class="searchArea">
		<strong class="title">등록일</strong>
		<input id="searchStartDate" name="search_start_dt" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $start_dt;?>">
		~
		<input id="searchEndDate" name="search_end_dt" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $end_dt;?>">
		<div class="n_search">
			<img id="BTN_SEARCH" src="../../web/images/button/hit_sm_btn.png" alt="조회" onclick="javascript:search_form.submit();">
		</div>
	</div>
	<!--// 검색 -->

	<p class="mg_b10">※ 조회 일시 : <?php echo date("Y/m/d H:i")?></p>
	<div class="searchArea02">
		<div class="n_class">
			<?php echo $paging_volume;?>
		</div>
		<p class="textRight"><span class="dataResult">총 <strong><?php echo $total_rows;?></strong>건의 데이터가 검색되었습니다.</span> 
		<a href="/statistics/mediaStatistics/media_excel?search_start_dt=<?php echo $start_dt;?>&search_end_dt=<?php echo $end_dt;?>&media_category_cd=<?php echo $media_category_cd;?>"><img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"></a></p>
	</div>
	</form>
	<table id="sortTable" class="compaingTable sortTable" summary="">
		<colgroup>
			<col width="">
			<col width="">
			<col width="">
			<col width="">
			<col width="">
		</colgroup>
		<thead>
			<tr>
				<th class="first" style="background-position-x: 70%">미디어 명</th>
				<th style="background-position-x: 70%">시도 건수</th>
				<th style="background-position-x: 70%">성공 건수</th>
				<th style="background-position-x: 65%">성공율</th>
				<th style="background-position-x: 70%">Click 수</th>
				<th style="background-position-x: 65%" class="end">CTR</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="6">검색결과가 없습니다.</td>
			</tr>
		<?php else: ?>
			<?php foreach($list as $statistics_vo): ?>
			<tr>
				<td><a href="javascript:window.open('/report/pcpMediaReport/detail?type=popup&media_id=<?php echo $statistics_vo->get_media_id();?>', 'pushPopup', 'width=1140, height=500, left=50, top=50, scrollbars=yes');"><?php echo $statistics_vo->get_media_nm();?></a></td>
				<td><?php echo number_format($statistics_vo->get_request_cnt());?></td>
				<td><?php echo number_format($statistics_vo->get_success_cnt());?></td>
				<td><?php echo $statistics_vo->get_success_rate();?>%</td>
				<td><?php echo number_format($statistics_vo->get_click_cnt());?></td>
				<td class="end"><?php echo $statistics_vo->get_click_rate();?>%</td>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
	<p class="mg_t20">※ 선택한 등록일(미디어) 기간에 속하는 지표를 미디어 카테고리 기준으로 산출하여 위 데이터를 제공합니다.</p>
	<div class="pagingList">
		<?php echo $paging;?>
	</div>
	<div class="btnC">
		<span><img src="../../web/images/button/n_btn_list.gif" alt="목록" onclick="javascript:history.back();"></span>
	</div>
</div>