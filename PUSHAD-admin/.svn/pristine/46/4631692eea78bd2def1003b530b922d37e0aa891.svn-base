<script type="text/javascript">
$(document).ready(function() {
	addDynatree('target_os_tree', <?php echo $target_os_list;?>, 'os_ver');
	addDynatree('target_device_tree', <?php echo $target_device_list;?>, 'model_nm');
	addDynatree('target_media_group_tree', <?php echo $target_media_group_list;?>, 'media_group_cd');
	addDynatree('target_media_category_tree', <?php echo $target_media_category_list;?>, 'media_category_cd');
	addDynatree('target_carrier_tree', <?php echo $target_carrier_list;?>, 'carrier_cd');
	addDynatree('target_gender_tree', <?php echo $target_gender_list;?>, 'gender_cd');
	addDynatree('target_age_tree', <?php echo $target_age_list;?>, 'age_rng_cd');
});
</script>

<div id="popTop">
	<h2>
		타게팅 설정
		<a href="#" class="closePopup" onclick="window.close();" style="line-height:0px;">
			<img src="/web/images/button/close_popup.gif" alt="창 닫기" />
		</a>
	</h2>
</div>
<div class="popWrapper" style="width:98%;">
	<form id="write_form" name="write_form">
		<input type="text" style="width:0;visibility:hidden;">
		<h4>타게팅 정보</h4>
		<!-- [D] 하기 모든 타게팅 그룹의 해제 선택 화면 표현은 'targetSet_on' 클래스 삭제 및 'targetSet_view' 클래스 숨김처리하시면 됩니다. -->
		<?php echo $this->load->view('campaign/advert/target/target_os_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_device_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_media_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_carrier_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_gender_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_age_layer', $this, true);?>
		<?php echo $this->load->view('campaign/advert/target/target_region_layer', $this, true);?>
		
		<div class="btnC">
			<span><a href="javascript:target_setting();"><img src="/web/images/button/0717_btn_com.gif" alt="완료" /></a></span>
		</div>
	</form>
</div>