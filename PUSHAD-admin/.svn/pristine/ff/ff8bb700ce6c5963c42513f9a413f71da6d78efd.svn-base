// gnb menu

function fnTopMenu1_Type1() {
	this.menu = new Array();
	this.menuseq = 0;
	
	this.Start = function() {
		this.MenuBox = document.getElementById(this.DivName).getElementsByTagName("ul")[0].childNodes;
		
		// 메뉴의 갯수를 파악하는 부분
		this.MenuLength = this.MenuBox.length;
		
		// 메뉴의 1뎁스 링크부분에 마우스나 키보드의 반응을 넣는 부분
		for ( var i=0; i<this.MenuLength; i++ ) {
			if ( this.MenuBox.item(i).tagName != "LI" ) { continue; }
			this.MenuLink = this.MenuBox.item(i).getElementsByTagName("a")[0];
			this.MenuLink.i = i;
			this.MenuLink.fnName = this.fnName;
			this.MenuLink.onmouseover = this.MenuLink.onfocus = function()	{ eval(this.fnName +".fnMouseOver(" + this.i + ")") }

			this.MenuSubBox = this.MenuBox.item(i).getElementsByTagName("div")[0];
			this.MenuSubMenu = this.MenuSubBox.getElementsByTagName("ul")[0].getElementsByTagName("li");
			this.MenuSubMenuLength = this.MenuSubMenu.length;
			
			// 메뉴의 2뎁스 링크부분에 마우스나 키보드의 반응을 넣는 부분
			for ( var j=0; j<this.MenuSubMenuLength; j++ ) {
				this.MenuSubLink = this.MenuSubMenu.item(j).getElementsByTagName("a")[0];
				this.MenuSubLink.i = i;
				this.MenuSubLink.j = j;
				this.MenuSubLink.fnName = this.fnName;
				this.MenuSubLink.onmouseover = this.MenuSubLink.onfocus = function()		{ eval(this.fnName +".fnMouseSubOver(" + this.i + "," + this.j + ")") }
				this.MenuSubLink.onmouseout = this.MenuSubLink.onblur = function()		{ eval(this.fnName +".fnMouseSubOut(" + this.i + "," + this.j + ")") }
			}
			
			this.MenuSubBox.style.display = "none";
			
			this.menuseq++;
			this.menu[this.menuseq] = i
		}
		
		if ( this.DefaultMenu != 0 ) {
			this.fnMouseOver(this.menu[this.DefaultMenu]);
			if ( this.DefaultSubMenu != 0 ) {
				this.fnMouseSubOver(this.menu[this.DefaultMenu],this.DefaultSubMenu - 1);
			}
		}
	}
	
	// 메뉴의 1뎁스 링크부분에 마우스나 키보드의 반응에 의해 실행하는 부분
	this.fnMouseOver = function(val) {
		for ( var i=0; i<this.MenuLength; i++ ) {
			if ( this.MenuBox.item(i).tagName != "LI" ) { continue; }
			this.MenuImg = this.MenuBox.item(i).getElementsByTagName("a")[0].getElementsByTagName("img")[0];
			this.MenuSDiv = this.MenuBox.item(i).getElementsByTagName("div")[0];
			if ( i == val ) {
				this.MenuImg.src = this.MenuImg.src.replace("_off.gif","_on.gif");
				this.MenuSDiv.style.display = "block";
			} else {
				this.MenuImg.src = this.MenuImg.src.replace("_on.gif","_off.gif");
				this.MenuSDiv.style.display = "none";
			}
		}
	}
	
	// 메뉴의 2뎁스 링크부분에 마우스나 키보드의 반응에 의해 실행하는 부분
	this.fnMouseSubOver = function(mnum,snum) {
		this.SubMenuImg = this.MenuBox.item(mnum).getElementsByTagName("div")[0].getElementsByTagName("ul")[0].getElementsByTagName("li")[snum].getElementsByTagName("a")[0].getElementsByTagName("img")[0];
		this.SubMenuImg.src = this.SubMenuImg.src.replace("_off.gif","_on.gif");
	}
	this.fnMouseSubOut = function(mnum,snum) {
		this.SubMenuImg = this.MenuBox.item(mnum).getElementsByTagName("div")[0].getElementsByTagName("ul")[0].getElementsByTagName("li")[snum].getElementsByTagName("a")[0].getElementsByTagName("img")[0];
		this.SubMenuImg.src = this.SubMenuImg.src.replace("_on.gif","_off.gif");
	}
	
}

//토글 스크립트 ~
function toggleList(tabContainer) {
 var tabContainer=document.getElementById(tabContainer)
 var triggers = tabContainer.getElementsByTagName("a");

 for(i = 0; i < triggers.length; i++) {
  if (triggers.item(i).href.split("#")[1])
   triggers.item(i).targetEl = document.getElementById(triggers.item(i).href.split("#")[1]);

  if (!triggers.item(i).targetEl)
   continue;

  triggers.item(i).targetEl.style.display = "none";
  triggers.item(i).className="";
  triggers.item(i).onclick = function () {
   if (tabContainer.current == this) {
    this.targetEl.style.display = "none";
    this.className="";
    tabContainer.current = null;
   } else {
    if (tabContainer.current) {
     tabContainer.current.targetEl.style.display = "none";
     tabContainer.current.className="";
    }
    this.targetEl.style.display = "block";
	this.className="on";
    tabContainer.current = this;
   }
   return false;
  }
 }
}

//파일찾기
function setFile(fileTxt) {
 var tForm = document.tForm;
 tForm.fileTxt.value = fileTxt; 
}


// 광고관리 : 소재미리보기 팝업 탭
function initTabMenu(tabContainerID) {
var tabContainer = document.getElementById(tabContainerID);
var tabAnchor = tabContainer.getElementsByTagName("a");
var i = 0;

for(i=0; i<tabAnchor.length; i++) {
if (tabAnchor.item(i).className == "tab")
thismenu = tabAnchor.item(i);
else
continue;

thismenu.container = tabContainer;
thismenu.targetEl = document.getElementById(tabAnchor.item(i).href.split("#")[1]);
thismenu.targetEl.style.display = "none";
thismenu.imgEl = thismenu.getElementsByTagName("img").item(0);
thismenu.onclick = function tabMenuClick() {
currentmenu = this.container.current;
if (currentmenu == this)
return false;

if (currentmenu) {
currentmenu.targetEl.style.display = "none";
if (currentmenu.imgEl) {
currentmenu.imgEl.src = currentmenu.imgEl.src.replace("_on.gif", "_off.gif");
}
else {
currentmenu.className = currentmenu.className.replace(" on", "");
}
}
this.targetEl.style.display = "";
if (this.imgEl) {
this.imgEl.src = this.imgEl.src.replace("_off.gif", "_on.gif");
}
else {
this.className += " on";
}
this.container.current = this;

return false;
};

if (!thismenu.container.first)
thismenu.container.first = thismenu;
}
if (tabContainer.first)
tabContainer.first.onclick();
}

//열고, 닫히는 new스크립트
var listOneFlag=true;
var listTwoFlag=false;
var listThreeFlag=false;
function listControl(id){
	if(id=="listOne"){
		if(listOneFlag) {$('#'+id).hide();listOneFlag=false;$('#'+id+"_img").removeClass("on");}
		else {$('#'+id).show();listOneFlag=true;$('#'+id+"_img").addClass("on");}
	}else if(id=="listTwo"){
		if(listTwoFlag) {$('#'+id).hide();listTwoFlag=false;$('#'+id+"_img").removeClass("on");}
		else {$('#'+id).show();listTwoFlag=true;$('#'+id+"_img").addClass("on");}
	}else if(id=="listThree"){
		if(listThreeFlag) {$('#'+id).hide();listThreeFlag=false;$('#'+id+"_img").removeClass("on");}
		else {$('#'+id).show();listThreeFlag=true;$('#'+id+"_img").addClass("on");}
	}
	
}
