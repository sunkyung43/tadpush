var isChange = false;
var menu_click_cancel = false;

$(document).ready(function() {
	$(".checkChange").bind("change", function() {
		isChange = true;
	});
});

function initMenuClickConfirm() {
	$(".gnb_link").click(function(e) {
		if(isChange && !confirm('등록 중이던 모든 정보가 삭제 됩니다. 이동 하시겠습니까?')) {
			menu_click_cancel = true;
		}
	});
	$(".lnb_link").click(function() {
		if(isChange && !confirm('등록 중이던 모든 정보가 삭제 됩니다. 이동 하시겠습니까?')) {
			menu_click_cancel = true;
		}
	});
}

function menuHandling(target_url, popup_flag) {
	if(menu_click_cancel) {
		menu_click_cancel = false;
		return;
	}

	if (popup_flag == '1') {
		obwindow = window
				.open(
						target_url,
						'full_screen',
						"fullscreen=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no")
	} else {
		location.replace(target_url);
	}
}

// 상단 서브메뉴 핸들링
function subMenuHandling(menu_num, action, top_menu_count) {
	for (i = 1; i <= top_menu_count; i++) {
		$("#gnbSub" + i).hide();
		$("#gnb" + i).removeClass('selection');
		if (menu_num == i) {
			$("#gnbSub" + i).show();
			$("#gnb" + i).addClass('selection');
		}
	}
}

//로그아웃
function logout() {
	if (confirm("로그아웃 하시겠습니까?")) {
		$.ajax({
			type : "POST",
			url : "/login/main/logout",
			dataType : "json",
			success : function(json) {
				if (json.response_type == 'success') {
					location.replace('/');
					return;
				}
			}
		});
	}
}