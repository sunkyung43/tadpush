<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 로그인, MDN 암호화 라이브러리
$config['use_crypto_library'] = false;

// ISF 연동 URL
$config['isf_url'] = 'http://push.adotsolution.com/pushad';

// Push Planet 연동 URL
$config['push_planet_url'] = 'https://pushapi.skplanetx.com';

//Push Planet 연동 id/pw
$config['push_planet_id'] = 'tadsdkdev';
$config['push_planet_pwd'] = 'tadsdkdev1';

/**
 * http://push.adotsolution.com/register_nt - 모수등록
 * http://push.adotsolution.com/agreement_nt - 동의/철회
 * http://push.adotsolution.com/terms_nt - 조회
 * http://push.adotsolution.com/evt_nt - 노출/클릭
 */
//약관철회 URL
$config['param_server_provision_select'] = 'http://push.adotsolution.com/terms_nt';
$config['param_server_provision_agree'] = 'http://push.adotsolution.com/agreement_nt';

//스케줄서버 연동 url
$config['linkage_schedule_svr'] = 'http://localhost:8000/targeting/';

// 디바이스 엑셀 템플릿 경로
// 업로드 기본 경로 : $_SERVER['DOCUMENT_ROOT'] .'/web/template/device_template.xls' 
$config['device_template_path'] = '';

// 미디어 엑셀 템플릿 경로
// 업로드 기본 경로 : $_SERVER['DOCUMENT_ROOT'] .'/web/template/media_template.xls'
$config['media_template_path'] = '';

// 엑셀 템플릿 업로드 설정
// 업로드 기본 경로 : $_SERVER['DOCUMENT_ROOT'] .'/web/temp'
$config['excel_template_upload_path'] = '';

// 이미지 업로드 설정
// 업로드 기본 경로 : $_SERVER['DOCUMENT_ROOT'] .'/web/creative'
$config['content_server_url'] = 'http://localhost/web/creative';
$config['creative_upload_path'] = '';

// 테스트용 ISF 인터페이스 무시
$config['disable_isf'] = true;

/* End of file tadpush.php */
/* Location: ./application/config/tadpush.php */
