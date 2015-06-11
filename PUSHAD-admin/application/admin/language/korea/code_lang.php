<?php

$lang['form_validation_error'] 	= '입력 데이터가 올바르지 않습니다.';
$lang['db_select_empty'] 		= '데이터가 존재하지 않습니다.';

// 매체 상태
$lang['media_status_ent'] 			= 'PSMDST';
$lang['media_status_cd_enable'] 	= 'PSMDST101';
$lang['media_status_cd_disable'] 	= 'PSMDST102';
$lang['media_status_cd_delete']		= 'PSMDST103';

// 매체 카테고리
$lang['media_category_ent'] = 'MEDCAT';

// 캠페인 상태
$lang['campaign_status_ent'] 		= 'PSCPST';
$lang['campaign_status_enable'] 	= 'PSCPST101';
$lang['campaign_status_delete'] 	= 'PSCPST102';

// 타켓팅 Type
$lang['target_type_jb'] 			= 'SUPPORT_JB_FL';
$lang['target_type_os_cd'] 			= 'OS_CD';
$lang['target_type_os_ver'] 		= 'OS_VER';
$lang['target_type_device'] 		= 'MODEL_NM';
$lang['target_type_vendor']			= 'VENDOR';
$lang['target_type_media'] 			= 'MEDIA_ID';
$lang['target_type_media_name'] 	= 'MEDIA_NAME';
$lang['target_type_media_group'] 	= 'MEDIA_GROUP';
$lang['target_type_media_category']	= 'MEDIA_CATEGORY';
$lang['target_type_carrier'] 		= 'CARRIER';
$lang['target_type_carrier_cd'] 	= 'CARRIER_CD';
$lang['target_type_gender'] 		= 'GENDER_CD';
$lang['target_type_age'] 			= 'AGE_RNG_CD';
$lang['target_type_region'] 		= 'ADDR_CD';
$lang['target_type_region_sido']	= 'ADDR_DO_CD';
$lang['target_type_region_gugun']	= 'ADDR_GUN_CD';

$lang['support_jb_flag'] = '1';

// 과금 Type
$lang['bill_type_ent'] = 'PSBLTP';
$lang['bill_type_cpm'] = 'PSBLTP101';
$lang['bill_type_cpc'] = 'PSBLTP102';

// device type
$lang['device_type_ent'] = 'DEVICE';

//AD 타겟팅상태
$lang['ad_targeting_ent'] 		= 'PSTGTP';
$lang['ad_targeting_universal'] = 'PSTGTP101';
$lang['ad_targeting_app'] 		= 'PSTGTP102';
$lang['ad_targeting_device'] 	= 'PSTGTP103';

// 통신사
$lang['device_carrier_ent'] = 'CARIER';
$lang['device_carrier_skt'] = '45005,450005';
$lang['device_carrier_kt'] = '45002,450002,45003,450003,45004,450004,45008,450008';
$lang['device_carrier_lgu'] = '45006,450006';
$lang['device_carrier_etc'] = 'ETC';
$lang['device_carrier_etc_att'] = 'CARIER8';

// 휴대폰 메이커
$lang['device_maker_ent'] = 'MAKER';

// 안드로이드 버젼 검색을 위한 ENT값
$lang['device_os_and_ent'] = 'OS101';
$lang['device_os_and_etc'] = 'ANDVERETC';

//해지자(CANCEL)상태
$lang['cancel_status_ent'] 				= 'PSCCL';
$lang['cancel_status_com'] 				= 'PSCCL101';
$lang['cancel_status_stand']		 	= 'PSCCL102';
$lang['cancel_status_del'] 				= 'PSCCL103';
$lang['cancel_status_restoration'] 		= 'PSCCL104';

//약관 동의 내용
$lang['terms_cancel'] 	= '0'; 	//철회
$lang['terms_null'] 	= '-1'; //미동의
$lang['terms_yn'] 		= '8'; 	//일부동의
$lang['terms_yy'] 		= '15'; //모두동의

// mdn 약관 상태
$lang['pro_status_ent'] 		= 'PSPVST';
$lang['pro_status_enable'] 		= 'PSPVST101';//배포
$lang['pro_status_disable'] 	= 'PSPVST102';//중지

// 프리징 타입
$lang['freezing_type_ent'] 			= 'PSFZTP';
$lang['freezing_type_today'] 		= 'PSFZTP101';	// 당일
$lang['freezing_type_yesterday'] 	= 'PSFZTP102';	// 전일

// 프리징 상태
$lang['freezing_status_ent'] 		= 'PSFZST';
$lang['freezing_status_standby'] 	= 'PSFZST104';
$lang['freezing_status_progress'] 	= 'PSFZST103';
$lang['freezing_status_before_end'] = 'PSFZST102';
$lang['freezing_status_end'] 		= 'PSFZST101';

// AD 상태
$lang['ad_status_ent'] 		= 'PSEAST';
$lang['ad_status_test'] 	= 'PSEADST01';
$lang['ad_status_stand'] 	= 'PSEADST02';
$lang['ad_status_send'] 	= 'PSEADST03';
$lang['ad_status_com']		= 'PSEADST04';

// 스케줄 상태
$lang['sch_status_ent'] = 'PSESST';
$lang['sch_status_ready'] = 'PSEIFST01';
$lang['sch_status_booking'] = 'PSEIFST02';
$lang['sch_status_booking_com'] = 'PSEIFST03';
$lang['sch_status_booking_fail'] = 'PSEIFST04';
$lang['sch_status_file'] = 'PSEIFST05';
$lang['sch_status_file_com'] = 'PSEIFST06';
$lang['sch_status_file_fail'] = 'PSEIFST07';
$lang['sch_status_file_down'] = 'PSEIFST08';
$lang['sch_status_cancel'] = 'PSEIFST09';
$lang['sch_status_cancel_com'] = 'PSEIFST10';
$lang['sch_status_cancel_fail'] = 'PSEIFST11';

// 소재타입
$lang['creative_type_ent']					= 'PSCTTP';
$lang['creative_type_text']					= 'PSCTTP101';
$lang['creative_type_image']				= 'PSCTTP102';
$lang['creative_type_popup_text_banner']	= 'PSCTTP103';
$lang['creative_type_popup_text']			= 'PSCTTP104';
$lang['creative_type_popup_image_banner'] 	= 'PSCTTP105';
$lang['creative_type_popup_image'] 			= 'PSCTTP106';
$lang['creative_type_jb_default']			= 'PSCTTP107';
$lang['creative_type_jb_big_text']			= 'PSCTTP108';
$lang['creative_type_jb_inbox']				= 'PSCTTP109';
$lang['creative_type_jb_big_picture']		= 'PSCTTP110';

// 소재 랜딩 타입
$lang['landing_type_ent'] 		= 'PSLDTP';
$lang['landing_type_web'] 		= '1';
$lang['landing_type_web_view'] 	= '2';
$lang['landing_type_app_dl']	= '3';
$lang['landing_type_run'] 		= '4';
$lang['landing_type_opt_out'] 	= '5';

// 성별
$lang['gender_ent'] = 'PSGDTP';

// 연령
$lang['age_ent'] = 'AGE';

//플랫폼
$lang['os_ent'] 		= 'OS';
$lang['os_android'] 	= '1';
$lang['os_ios'] 		= '2';

// 모수 상태
$lang['param_status_ent'] = 'PSPMST';
$lang['param_status_enable'] = 'PSPMST101';
$lang['param_status_disable_ready'] = 'PSPMST102';
$lang['param_status_disable'] = 'PSPMST103';

/* End of file code_lang.php */
/* Location: ./system/language/korea/code_lang.php */