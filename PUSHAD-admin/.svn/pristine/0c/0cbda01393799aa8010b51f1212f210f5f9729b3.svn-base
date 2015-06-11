
/* 펼침메뉴 js*/
function showLayerReq(num, id_name){
    if (num == 2) {
        document.getElementById(id_name).style.display = "block";
    }
    else  {
        document.getElementById(id_name).style.display = "none";
    }
}


			$(function(){
			
				
				toggleLayer();				
				toggleTab();				
				NoticeToggle();
				togglePopTab();
			});
			
			function toggleLayer(){
				$(".contArea :checkbox").bind("click", function(){
					var checked = $(this).get(0).checked;
					var p = $(this).parent();

					if( checked )
						 p.find("+div").show("slow");
					else
						 p.find("+div").hide("slow");					
				});
			}
			
			function toggleLayer(){
				$(".contArea :checkbox").bind("click", function(){
					var checked = $(this).get(0).checked;
					var p = $(this).parent();

					if( checked )
						 p.find("+div").show("slow");
					else
						 p.find("+div").hide("slow");					
				});
			}
			function NoticeToggle(){
				$("#noticeListBox span a").bind("click", function(){
					var checked = $(this).get(0).checked;
					var p = $(this).parent();

					if( checked )
						 p.find("+div").show("slow");
					else
						 p.find("+div").hide("slow");					
				});
			}
			
			function toggleTab(){
				$(".tabArea span a").bind("click", function(){
					var index= $(".tabArea span a").index($(this));
					$(".tabArea div").hide();
					$(".tabArea div:eq(" + index + ")").show();
				});
				
				var kIndex = $(".tabArea span a").index($(".tabArea span a.selected"));
				if( kIndex == 0 )
				{
					$(".tabArea div").hide();
					$(".tabArea div:eq(" + kIndex + ")").show();
				}
			}
			
			
			function togglePopTab(){
				$(".tabArea li a").bind("click", function(){
					var index= $(".tabArea li a").index($(this));
					$(".tabArea div").hide();
					$(".tabArea div:eq(" + index + ")").show();
				});
				
				var kIndex = $(".tabArea li a").index($(".tabArea li a.selected"));
				if( kIndex == 0 )
				{
					$(".tabArea div").hide();
					$(".tabArea div:eq(" + kIndex + ")").show();
				}
			}


/* 20110530추가 windowOpen */
function winOpen(url, n, w, h, s) {
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+s+',resizable'
win = window.open(url, n, winprops)
if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}