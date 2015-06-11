<script type="text/javascript">
<!--
    $(document).ready(function() {
    	create_dual_calendar('#searchStartDate', '#searchEndDate');
		});
//-->
</script>
	
	<!--컨텐츠 -->
	<div id="content">
	<form id="list_form" name="list_form" action="" method="get">
		<div class="subTitleArea">
			<h3>미디어 리포트</h3>
		</div>
		<hr />
		<!-- 검색 //-->
		<div class="searchArea">
			<div class="n_class">
				<span class="title">상태</span>
				<?php echo $status_type_selectbox; ?>
				&nbsp;
				<span class="title">플랫폼</span>
				<?php echo $platform_selectbox; ?>
				&nbsp;
				<span class="title">카테고리</span>
				<?php echo $category_selectbox; ?>
				&nbsp;
				<span class="title">기간</span>
				<input id="searchStartDate" name="searchStartDate" class="textType" style="width:70px;" title="조회 시작일 입력" type="text" value="<?php echo $searchStartDate;?>" />
				~
				<input id="searchEndDate" name="searchEndDate" class="textType" style="width:70px;" title="조회 종료일 입력" type="text" value="<?php echo $searchEndDate;?>"/> 
			</div>
			<div class="n_search">
				<span class="title">검색조건</span>
				<?php echo $search_type_selectbox; ?>
				<input type="text" id="searchValue" name="searchValue" class="textType" title="검색어 입력" value="<?php echo $search_value;?>" />
				<a href="javascript:search();"><img id="BTN_SEARCH" src="../../web/images/button/search.gif" style="cursor: pointer;" alt="검색" /></a>
			</div>
		</div>
		<!--// 검색 -->
		<div class="searchArea02">
			<div class="n_class">
				<?php echo $paging_volume; ?>
			</div>
			<div class="n_search">
				총 <span class="point01"><strong><?php echo $total_rows;?></strong></span> 건의 데이터가 검색되었습니다.
				<a href="/report/pcpMediaReport/list_excel?status_type=<?php echo $status_type;?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>&search_type=<?php echo $search_type;?>&search_value=<?php echo $search_value;?>&platform_type=<?php echo $platform_type;?>&category_cd=<?php echo $category_cd;?>">
					<img src="../../web/images/button/excel_btn33.png" alt="엑셀 다운로드"/>
				</a>
			</div>
		</div>

		<table summary="" class="compaingTable">
		<colgroup>
		<col width="3%" />
		<col width="3%" />
		<col width="7%" />
		<col width="9%" />
		<col width="7%" />
		<col width="7%" />
		<col width="7%" />
		<col width="7%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		</colgroup>
		<thead>
			<tr>
				<th class="first"></th>
				<th>No</th>
				<th>등록일</th>
				<th>미디어 명</th>
				<th>APP ID</th>
				<th>플랫폼</th>
				<th>카테고리</th>
				<th>상태</th>
				<th>시도</th>
				<th>성공</th>
				<th>성공률</th>
				<th>Click</th>
				<th>CTR</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!isset($list) || empty($list)): ?>
			<tr>
				<td colspan="13">검색결과가 없습니다.</td>
			</tr>
		<?php else: ?>
			<?php foreach($list as $report_vo): ?>
			<tr>
				<td><input type="radio" name="select_media_id" value="<?php echo $report_vo->get_media_id();?>" /></td>
				<td><?php echo $report_vo->get_row_num();?></td>
				<td><?php echo $report_vo->get_create_dt();?></td>
				<td><a href="/report/pcpMediaReport/detail?media_id=<?php echo $report_vo->get_media_id(); ?>&searchStartDate=<?php echo $searchStartDate;?>&searchEndDate=<?php echo $searchEndDate;?>"><?php echo $report_vo->get_media_nm();?></a></td>
				<td><?php echo $report_vo->get_media_key();?></td>
				<td><?php echo $report_vo->get_media_os_nm();?></td>
				<td><?php echo $report_vo->get_media_category_nm();?></td>
				<td><?php echo $report_vo->get_media_status_nm();?></td>
				<td><?php echo number_format($report_vo->get_request_cnt());?></td>
				<td><?php echo number_format($report_vo->get_success_cnt());?></td>
				<td><?php echo $report_vo->get_success_per();?>%</td>
				<td><?php echo number_format($report_vo->get_tot_click());?></td>
				<td class="end"><?php echo $report_vo->get_ctr_cnt();?>%</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
		</table>

		<div class="pagingList">
			<?php echo isset($paging) ? $paging : ''; ?>
		</div>
		
		<div class="btnListArea">
			<p class="floatL">
				<span>선택항목</span>
				<select id="actionType" name="actionType" class="mg_r10">
					<option value="">선택</option>
					<option value="Y">등록 미디어 보기</option>
				</select>
				<a href="javascript:executeAction();"><img src="../../web/images/button/btn_action.gif" alt="실행" /></a>
			</p>
		</div>
</form>
	</div>
<!-- //content-->