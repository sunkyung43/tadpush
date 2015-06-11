//document.write("<script src='jquery-1.4.2.min.js'></script>");

//function handlingMenu(menuId){
//	var menuSrc = $("#"+menuId).attr("src");
//	var menu1 = menuSrc.substring(0, menuSrc.indexOf(".gif"));
//	menu1 += "_on.gif";
//	$("#"+menuId).attr("src", menu1);
//}




//target의 자리수가 1자리면 앞에 0을 붙여서 반환한다.
function numberFormat(target){
	var retVal = "";
	if(target.length == 1){
		retVal = "0" + target;
	}else{
		retVal = target;
	}
	return retVal;
}

//해당 년, 월의 마지막 날자를 구한다.
function lastDay(year, month){
   var curDate = new Date();
   var lastDate = new Date(year, month, "");
   return lastDate.getDate();
}

//obj 가 널인지, 해당 Byte 범위 내에 있는지 체크한다.
function isText(obj, fieldName, minByte, maxByte){
	if(!isNull(obj, fieldName)){
		var value = obj.value;
		var byteLen = getByteSize(obj);
		if(byteLen < minByte || byteLen > maxByte){
			alert(fieldName + "은(는) 최소 " + minByte + "byte이상, 최대 " + maxByte + "byte 이하로 입력가능합니다.");
			obj.focus();
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

//obj value 의 max length 체크
function isMaxLength(obj, fieldName, maxByte, isNullVar){
	if(isNullVar){
		if(isNull(obj, fieldName)){
			return true;
		}
	}
	var value = obj.value;
	var byteLen = getByteSize(obj);
	if(byteLen > maxByte){
		alert(fieldName + " 은(는) " + maxByte + "byte 이하로 입력가능합니다.");
		obj.focus();
		return true;
	}else{
		return false;
	}
}

//obj value 의 min length 체크
function isMinLength(obj, fieldName, minByte, isNullVar){
	if(isNullVar){
		if(isNull(obj, fieldName)){
			return true;
		}
	}
	var value = obj.value;
	var byteLen = getByteSize(obj);
	if(byteLen < minByte){
		alert(fieldName + " 은(는) " + minByte + "byte 이상 입력해야 합니다.");
		obj.focus();
		return true;
	}else{
		return false;
	}
}

//null check
function isNull(obj, fieldName){
	var value = obj.value;
	if(value == ""){
		alert(fieldName + " 은(는) 필수입력 사항입니다.");
		obj.focus();
		return true;
	}
	return false;
}

function isEmailValid(obj, maxByte){
	if(isMaxLength(obj, "이메일", maxByte, true)) return true;
	var email = obj.value;
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if(filter.test(email)){
		return false;
	}else{
		alert("이메일 형식이 잘못되었습니다.");
		obj.focus();
		return true;
	}
	
}

//숫자만 입력받기
function numbersonly(e, decimal) { 
    var key; 
    var keychar; 

    if (window.event) { 
       // IE에서 이벤트를 확인하기 위한 설정 
        key = window.event.keyCode; 
    } else if (e) { 
      // FireFox에서 이벤트를 확인하기 위한 설정 
        key = e.which; 
    } else { 
        return true; 
    } 

    keychar = String.fromCharCode(key); 
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) 
            || (key == 27)) { 
        return true; 
    } else if ((("0123456789").indexOf(keychar) > -1)) { 
        return true; 
    } else if (decimal && (keychar == ".")) { 
        return true; 
    } else 
        return false; 
}


/**
 * input control의 byte 사이즈를 조회한다.
 * @param obj - input field
 * @return byte size
 */
function getByteSize(obj) {
	var type = "";
	
	if(obj.length == undefined) {
		type = obj.getAttribute("type");
	} else {
		type = obj[0].getAttribute("type");
	}

	if(type == "checkbox" || type == "radio") {
		var rtnVal = 0;
		if(obj.length == undefined) {
			if(obj.checked) {
				rtnVal = 1;
			} 
		} else {
			for(var i = 0; i < obj.length; i++) {
				if(obj[i].checked) {
					rtnVal = 1;
					break;
				}
			}		
		}
		return rtnVal;
	}
				
	var str = obj.value;
    var sum = 0;
    var len = str.length;
    for(var i = 0; i < len; i++) {
        var ch = str.substring(i, i + 1);
        var en = escape(ch);
        if(en.length <= 4) {
            sum++;
        } else {
            sum += 2;
        }
    }
    return sum;
}

function getValueByteSize(str){
    var sum = 0;
    var len = str.length;
    for(var i = 0; i < len; i++) {
        var ch = str.substring(i, i + 1);
        var en = escape(ch);
        if(en.length <= 4) {
            sum++;
        } else {
            sum += 2;
        }
    }
    return sum;
}

function substringGetByte(obj, byte){
	if(byte == 0){
		return "";
	}
	var str = obj.value;
	var returnValue = "";
    var sum = 0;
    var len = str.length;
    for(var i = 0; i < len; i++) {
        var ch = str.substring(i, i + 1);
        var en = escape(ch);
        if(en.length <= 4) {
            sum++;
        } else {
            sum += 2;
        }
        if(sum > byte){
    		returnValue = str.substring(0,i);
        	break;
        }
    }
    return returnValue;
}


/**
 * 두 개의 문자열을 비교 합니다.
 * 비교 문자열이 같으면 true, 다르면 false.
 * @param arg1 - 비교할 문자열1 
 * @param arg2 - 비교할 문자열2
 */
function isStringCompare(arg1, arg2) {
	if(arg1.trim() == arg2.trim()){
		return true;
	} else {
		return false;
	}
} 


/**
 * 두 개의 시작날짜와 끝날짜 사이의 기간을 비교 합니다.
 * 두 날짜 기간이 올바르면 true, 올바르지 않으면 false.
 * @param arg1 - 비교할 시작날짜
 * @param arg2 - 비교할 끝날짜
 */
function isDateOrder(obj1, obj2) {
	isNumeric(obj1, '', 8, 8);
	isNumeric(obj2, '', 8, 8);
	
	if(parseInt(obj1.value, 10) <= parseInt(obj2.value, 10)) {
		return true;
	} else {
		alert('입력 된 값의 크기가 잘못 되었습니다.');
		return false;
	}
}


//############################ COOKIE ############################
/**
* setCookie
*/
function setCookie(name, value ){ 
  var today = new Date();
  today.setDate( today.getDate() + 7 );
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";"
}

/**
*	delCookie
*/
function delCookie(name){
	var today = new Date();
	today.setDate(today.getDate() -1);
	document.cookie = name + "=;expires=" + today.toGMTString() + ";";
}

/**
*	getCookie
*/
function getCookie(name) { 
	var index = document.cookie.indexOf(name + "="); 
	if (index == -1) return ""; 
	index = document.cookie.indexOf("=", index) + 1; 
	var endstr = document.cookie.indexOf(";", index); 
	if (endstr == -1) endstr = document.cookie.length; 
	return unescape(document.cookie.substring(index, endstr)); 
} 


//숫자만 입력가능하게
function setNum(evt){
	var eCode = (window.netscape) ? evt.which : event.keyCode;
	//if( navigator.appName.indexOf("Microsoft") > -1 ){ // 마이크로소프트 익스플로러인지 확인
	//	eCode = event.keyCode;
  	//}else{// 익스플로러가 아닐 경우
	//	eCode = e.keyCode;
    //}
	//alert("eCode :: " + eCode);
	if(!(eCode > 47 && eCode <58) && eCode != 8 && eCode != 37 && eCode != 39 && eCode != 46 && eCode != 9 && eCode != 13 && !(eCode > 95 && eCode < 106) && eCode != 144 && eCode != 31 && eCode != 39){
		return false;
	}
}

//enter check
function enterCheck(evt){
	var eCode = (window.netscape) ? evt.which : event.keyCode;
	if(eCode == 13){
		return true;
	}else{
		return false;
	}
}

//POPUP 호출
function openPopup(method, targetName, url, option, form){
	if(method.toUpperCase() == "POST"){ //post
		window.open("", targetName, option);
		form.target = targetName;
		form.action = url;
		form.submit();
	}else{ //get
		window.open(url, targetName, option);
	}
}

/**
 * 문자열 트림
 */
String.prototype.trim = function() {
	return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}	


/**
 * Ajax POST전송 모듈
 * 
 * @param frmObj Form 오브젝트
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL
 * 
 * ex : onclick="getAjaxPost(document.testForm, dataSetFunction, '')
 *   function dataSetFunction(jsonBean) {
 *	  alert(jsonBean.check);
 * }
 *   function dataSetFunction(jsonBean) {
 *	  for(var i=0; jsonBean.beanlist != null && i < jsonBean.beanlist.length ; i++ ) {
 *		  alert(jsonBean.beanlist[i].id + "\n" + jsonBean.beanlist[i].name);  
 *	  } 
 *   }
	@RequestMapping(value = "/dpoc/acc/test.do")
	public void test(HttpServletRequest req, HttpServletResponse res,
			ModelMap model) throws Exception {

		MyBean myBean1 = new MyBean();
		myBean1.setId(1);
		myBean1.setName("mudchobo");
		MyBean myBean2 = new MyBean();
		myBean2.setId(2);
		myBean2.setName("shit");

		List<MyBean> mybeanList = new ArrayList<MyBean>();
		mybeanList.add(myBean1);
		mybeanList.add(myBean2);

		JSONArray jsonArray = JSONArray.fromObject(mybeanList);
		System.out.println("mybeanList - " + jsonArray);

		Map<String, Object> map = new HashMap<String, Object>();
		map.put("beanlist", jsonArray);

		JSONObject jsonObject = JSONObject.fromObject(map);

		jsonObject.element("check", 1);
		jsonObject.element("check", 2);
		System.out.println("json - " + jsonObject);
		res.getWriter().println(jsonObject.toString());

	}
 */
function getAjaxPost(frmObj, successFunction, actionURL) {
	
	var formAction = actionURL;
	var formName = "#" + frmObj.name;
	var str = $(formName).serialize();
	if (actionURL == null || actionURL.length < 1) {
		formAction = frmObj.action;
	}
	// JQUERY AJAX 처리 
	$.ajax({
		type: "POST",
		dataType : "json",
		url: formAction,
		data: str,
		form : formName,
		// 데이터를 받아왔을 경우
		success: successFunction,
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); }					
	});
}

/**
 * Ajax GET 타입 전송 모듈
 * 
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
  function successFunction(jsonBean) { // jsonBean은 서버로 부터 받은 오브젝트
	  setCommonCodeSelect(document.testForm.ppp, jsonBean, '선택하세요');
  }
 */
function getAjaxGet(successFunction, actionURL) {

	// JQUERY AJAX 처리 
	$.ajax({
		type: "GET",
		dataType : "json",
		url: actionURL,
		// 데이터를 받아왔을 경우
		success: successFunction,
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); }					
	});
}

/**
 * 공통 코드 Ajax전송 모듈
 * 
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
 * ex :
 * <select name="obbobb" onchange="getAjaxGetCodeSelect(this, document.testForm.ppp, '선택해주세요.');">
 */
function getAjaxGetCodeSelect(selObj, targetObject, defaultMessage) {
	  
	  var codeGroup = "";
	  if (selObj != null && selObj.options != null) {
		  codeGroup = selObj.options[selObj.selectedIndex].value;;
	  } else if (selObj != null) {
		  codeGroup = selObj;
	  }
	  // include.jsp 파일을 사용해야만 CONTEXTE_ROOT를 사용가능
	  var contextRoot = CONTEXTE_ROOT;
	  // 이하코드의 contextRoot가 실제 / 경우 에러가능성 있음 / 이고 접근 패스가 /abc/bb/c 일경우 
	  //var contextRoot = window.location.pathname.replace("//","/").split( '/' )[1];
	  //if (contextRoot != null && contextRoot.length > 0 ) {
	  //  contextRoot = "/" + contextRoot;
	  //} else {
	  //  contextRoot = "";
	  //}
	  var actionURL = contextRoot + "/comon/code/getJsonCommonCodeList.do?codeGroup=" + codeGroup;
	  
	// JQUERY AJAX 처리 
	$.ajax({
		type: "GET",
		dataType : "json",
		url: actionURL,
		// 데이터를 받아왔을 경우
		success: function(jsonBean){
			setCommonCodeSelect(jsonBean, targetObject, defaultMessage);
		 },
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); }					
	});
}

/**
 * 공통 코드 리스트 데이터를 취득해 콤보박스에 세팅하는 모듈
 * 
 * @param targetObj 대상 오브젝트 (target : document.forms[0].formSelect
 * @param jsonBean JSON 데이타 리스트
 * @param defaultMessage 콤보복스 맨위의 메세지 (선택하세요)
 */
function setCommonCodeSelect(jsonBean, targetObj, defaultMessage) {

	  if (jsonBean != null && jsonBean.jsonList != null && jsonBean.jsonList.length > 0 ) {
		  // 데상 오브젝트 초기화
		  targetObj.length = 0;
		  if (defaultMessage != null && defaultMessage.length > 0 ) {
			  var n_op = new Option(defaultMessage,'');
			  targetObj.options.add(n_op,targetObj.options.length);
		  }
		  // 리스트의 데이타를 세팅
		  for(var i=0; jsonBean.jsonList != null && i < jsonBean.jsonList.length ; i++ ) {
			  var n_op = new Option(jsonBean.jsonList[i].label, jsonBean.jsonList[i].codeKey);
			  targetObj.options.add(n_op,targetObj.options.length);
		  }
	  } else {
		  // 데상 오브젝트 초기화
		  targetObj.length = 0;
		  if (defaultMessage != null && defaultMessage.length > 0 ) {
			  var n_op = new Option(defaultMessage,'');
			  targetObj.options.add(n_op,targetObj.options.length);
		  }  
	  }	  
}

/**
 * 공통 코드 Ajax전송 모듈
 * 
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
 * ex :
 * <select name="obbobb" onchange="getAjaxGetCodeSelect(this, document.testForm.ppp, '선택해주세요.');">
 */
function getAjaxGetCodeDetail(codeKey, successFunction) {
	  
	  var codeGroup = codeKey;
	  // include.jsp 파일을 사용해야만 CONTEXTE_ROOT를 사용가능
	  var contextRoot = CONTEXTE_ROOT;
	  var actionURL = contextRoot + "/comon/code/getJsonCommonCodeDetail.do?codeGroup=" + codeGroup + "&date="+ new Date().getTime();
	  
	// JQUERY AJAX 처리 
	$.ajax({
		type: "GET",
		dataType : "json",
		url: actionURL,
		// 데이터를 받아왔을 경우
		success: successFunction,
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); }					
	});
}

/**
 * True/False 체크 Ajax GET 타입 전송 모듈
 * 
 * 0: false, 1 : true
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
  function successFunction(jsonBean) { // jsonBean은 서버로 부터 받은 오브젝트
	  setCommonCodeSelect(document.testForm.ppp, jsonBean, '선택하세요');
  }
 */


/**
 * True/False 체크 Ajax GET 타입 전송 모듈
 * 
 * 0: false, 1 : true
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
  function successFunction(jsonBean) { // jsonBean은 서버로 부터 받은 오브젝트
	  setCommonCodeSelect(document.testForm.ppp, jsonBean, '선택하세요');
  }
 */
function isCheckAjaxGet(actionURL) {
	 CHECK_AJAX_FLAG = false;
	// JQUERY AJAX 처리 
	$.ajax({
		type: "GET",
		dataType : "json",
		url: actionURL,
		// 데이터를 받아왔을 경우
		success:isCheckAjaxServerResult,
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); return false; }					
	});
}
/**
 * True/False 체크 Ajax POST 타입 전송 모듈
 * 
 * 0: false, 1 : true
 * @param successFunction javascript펑션명
 * @param actionURL Form의 URL및 파라메타
  function successFunction(jsonBean) { // jsonBean은 서버로 부터 받은 오브젝트
	  setCommonCodeSelect(document.testForm.ppp, jsonBean, '선택하세요');
  }
 */
function isCheckAjaxPost(frmObj, actionURL) {
	 CHECK_AJAX_FLAG = false;
	var formAction = actionURL;
	var formName = "#" + frmObj.name;
	var str = $(formName).serialize();
	if (actionURL == null || actionURL.length < 1) {
		formAction = frmObj.action;
	}
	// JQUERY AJAX 처리 
	$.ajax({
		type: "POST",
		dataType : "json",
		url: formAction,
		data: str,
		form : formName,
		// 데이터를 받아왔을 경우
		success: isCheckAjaxServerResult,
		// 데이터를 못받아 왔을 경우
		error : function(e) {alert("처리중 장애가 발생하였습니다 .\n" + e ); return false;}					
	});
}
/**
 * isCheckAjaxFlag
 */
var CHECK_AJAX_FLAG = false;
/**
 * True/False 체크 서버 결과값
 * @param jsonBean
 * @return
 */
function isCheckAjaxServerResult(jsonBean) {
		if (jsonBean.check == "1" || jsonBean.check == 1) {
			CHECK_AJAX_FLAG = true;
		} else {
			CHECK_AJAX_FLAG = false;
		}
}

/* 달력 셋팅 */
function comDatePicker(from_id ,to_id){
	// 2010-10-19 년도/달 선택 옵션 해제(디자인 이슈때문에) jhhur
	// 2010-10-29 년도/달 선택 옵션 활성화(디자인 파일 직접 수정) jhhur
	$("#"+from_id).datepicker({yearRange:'-100:+20', changeMonth:true, changeYear:true, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	//$("#"+from_id).datepicker({yearRange:'-100:+20', changeMonth:false, changeYear:false, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	if(to_id != null) {
		$("#"+to_id).datepicker({yearRange:'-100:+20', changeMonth:true, changeYear:true, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
		//$("#"+to_id).datepicker({yearRange:'-100:+20', changeMonth:false, changeYear:false, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	}
}

/* 달력 셋팅 */
function comDatePickerNoHyphen(from_id ,to_id){
	// 2010-10-19 년도/달 선택 옵션 해제(디자인 이슈때문에) jhhur
	// 2010-10-29 년도/달 선택 옵션 활성화(디자인 파일 직접 수정) jhhur
	$("#"+from_id).datepicker({yearRange:'-100:+20', changeMonth:true, changeYear:true, showOn:'button', dateFormat:'yymmdd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	//$("#"+from_id).datepicker({yearRange:'-100:+20', changeMonth:false, changeYear:false, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	if(to_id != null) {
		$("#"+to_id).datepicker({yearRange:'-100:+20', changeMonth:true, changeYear:true, showOn:'button', dateFormat:'yymmdd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
		//$("#"+to_id).datepicker({yearRange:'-100:+20', changeMonth:false, changeYear:false, showOn:'button', dateFormat:'yy-mm-dd', buttonImageOnly:true, buttonImage:CONTEXTE_ROOT+'/images/common/icon_calendar.gif'});
	}
}



function toggleBtn(targetId, cssTarget){
	if($("#" + cssTarget).hasClass("on")){
		$("#" + targetId).hide();
		$("#" + cssTarget).removeClass("on");
	}else{
		$("#" + targetId).show();
		$("#" + cssTarget).addClass("on");
	}
}
//UserId Check 필수입력, MinLen:6, MaxLen:16, 영문(필수포함), 숫자 이외에 입력 불가
function checkUserId(obj, fieldName){
	var pattern = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/; 
	if(isMinLength(obj, fieldName, 6, true)) return false;
	else if(isMaxLength(obj, fieldName, 16, false)) return false;
	else if(!isRegexpMatch(pattern, obj.value)){ 
	    alert(fieldName + " '" + obj.value + "' 은 사용이 불가능 합니다. \n 영문(필수포함)이나 숫자만 입력 가능합니다.");
		obj.focus(); 
	    return false;
	}
	return true;
}

//Password Check 필수입력, MinLen:6, MaxLen:16, 영문, 숫자, 특문(~!@#$%^&*()) 외에 입력 불가
function checkPassword(obj, fieldName){
	var pattern = /(^[a-zA-Z0-9~!@#$%^&*()]+$)/;
	if(isMinLength(obj, fieldName, 6, true)) return false;
	else if(isMaxLength(obj, fieldName, 16, false)) return false;
	else if(!isRegexpMatch(pattern, obj.value)){ 
	    alert("패스워드는 영문,숫자,~!@#$%^&*() 외에 입력이 불가합니다.");
		obj.focus();
	    return false;
	}
	return true;
}
//UserId Check 필수입력, MinLen:6, MaxLen:16, 영문(필수포함), 숫자 이외에 입력 불가
function checkUserIdValue(val, fieldName){
	var pattern = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/; 
	if(val == ""){
		alert(fieldName + "은(는) 필수 입력입니다.");
		return false;
	}
	var byteSize = getValueByteSize(val);
	if(byteSize < 6){
		alert(fieldName + " 은(는) 6byte 이상 입력해야 합니다.");
		return false;
	} else if(byteSize > 16){
		alert(fieldName + " 은(는) 16byte 이하로 입력가능합니다.");
	} else if(!isRegexpMatch(pattern, val)){ 
	    alert(fieldName + " '" + val + "' 은 사용이 불가능 합니다. \n 영문(필수포함)이나 숫자만 입력 가능합니다.");
	    return false;
	}
	return true;
}

//정규표현식 Match 결과
function isRegexpMatch(regexp, val){
	return regexp.test(val); 
}

// Session 종료시 로그인 페이지로 이동
function closeSession(context){
	alert("세션이 종료되었습니다.");
	document.location.href = context + "/loginPage.do";
}

//모달

function openModal(){
	$('#modalLayer').modal({
		overlayCss: {backgroundColor:"#000"}, // bg색상
		overlayClose:true //bg클릭시 close여부
	});
}
