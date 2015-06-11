<?php

class Utility {
	var $CI = '';

	function __construct() {
		$this->CI = &get_instance();
	}
	
	// 파일 업로드
	// $field_name : 업로드시 input file의 name
	// $config : CI file upload 초기화 $config
	function fileUpload($field_name, $config) {
		$files = $_FILES[$field_name];
		if ($files['name'] == '') {
			return array (
					'msg' => '선택된 파일이 없습니다.' 
			);
		}
		
		if (!is_uploaded_file($files['tmp_name'])) {
			$error = array (
					'error' => '파일이 정상적으로 업로드 되지 않았습니다.',
					'msg' => '파일이 정상적으로 업로드 되지 않았습니다.' 
			);
			return $error;
		}
		
		if (empty($config['upload_path'])) {
			$error = array (
					'error' => '업로드할 경로가 지정되지 않았습니다.',
					'msg' => '업로드할 경로가 지정되지 않았습니다.' 
			);
			return $error;
		}
		
		// dirname, basename, extention, filename
		$path_info = pathinfo($files['name']);
		
		// 파일확장자체크 : 확장자가 없는 파일은 파일이 아닌것으로 간주한다.
		if (empty($path_info['extension'])) {
			$error = array (
					'error' => '업로드 가능한 파일이 아닙니다.',
					'msg' => '파일 확장자가 없습니다.' 
			);
			return $error;
		}
		
		// 확장자 체크
		$extention = strtolower($path_info['extension']);
		if (!empty($config['allowed_types']) && !preg_match('/(^' . $config['allowed_types'] . ')/', $extention)) {
			$error = array (
					'error' => '업로드 가능한 파일이 아닙니다.',
					'msg' => '확장자가 올바르지 않습니다.' 
			);
			return $error;
		}
		
		// 디렉토리가 없는경우 생성
		if (!is_dir($config['upload_path'])) {
			if (!mkdir($config['upload_path'], 0777, true)) {
				$error = array (
						'error' => '업로드 파일 저장을 실패했습니다.',
						'msg' => '디렉토리 생성에 실패하였습니다.' 
				);
				return $error;
			}
		}
		
		// max_width 또는 max_height 가 있는경우 이미지로 간주
		$image_info = getimagesize($files['tmp_name']);
		if (!empty($config['image_size']) && empty($image_info)) {
			$error = array (
					'error' => '업로드한 파일은 이미지 파일이 아닙니다.',
					'msg' => '이미지 파일이 아닙니다.' 
			);
			return $error;
		}
		
		// 이미지인경우 처리
		if (!empty($image_info) && isset($config['image_size'])) {
			if (is_array($config['image_size'])) {
				$image_size_check = false;
				foreach ( $config['image_size'] as $image_size ) {
					if ($image_size[0] == $image_info[0] && $image_size[1] == $image_info[1]) {
						$image_size_check = true;
					}
				}
				
				if ($image_size_check == false) {
					$allow_image_size = '';
					foreach ( $config['image_size'] as $image_size ) {
						$allow_image_size .= $allow_image_size != '' ? ', ' : '';
						$allow_image_size .= $image_size[0] . 'x' . $image_size[1];
					}
					$error = array (
							'error' => '업로드 가능한 이미지 사이즈는 ' . $allow_image_size . ' 입니다.',
							'msg' => '업로드 가능한 이미지 사이즈는 ' . $allow_image_size . ' 입니다.' 
					);
					return $error;
				}
			} else {
				$image_size = $config['image_size'];
				if ($image_size[0] != $image_info[0] || $image_size[1] != $image_info[1]) {
					$error = array (
							'error' => '업로드 가능한 이미지 사이즈는 ' . $image_size[0] . 'x' . $image_size[1] . ' 입니다.',
							'msg' => '업로드 가능한 이미지 사이즈는 ' . $image_size[0] . 'x' . $image_size[1] . ' 입니다.' 
					);
					return $error;
				}
			}
			unset($config['image_size']);
		}
		
		// 파일 사이즈 체크 소수점 2자리까지 체크 KByte 기준
		if (!empty($config['max_size']) && $config['max_size'] > 0 && round(filesize($files['tmp_name']) / 1024, 2) > $config['max_size']) {
			$error = array (
					'error' => '업로드 가능한 파일크기는 ' . $config['max_size'] . 'KByte 입니다.',
					'msg' => '업로드 가능한 파일크기는 ' . $config['max_size'] . 'KByte 입니다.' 
			);
			return $error;
		}
		
		if (!$this->CI->load->is_loaded('upload')) {
			$this->CI->load->library('upload', $config);
		} else {
			$this->CI->upload->initialize($config);
		}
		
		if (!$this->CI->upload->do_upload($field_name)) {
			$error = array (
					'error' => $this->CI->upload->display_errors(),
					'msg' => '파일 업로드에 실패하였습니다.' 
			);
			return $error;
		} else {
			$data = array (
					'upload_data' => $this->CI->upload->data(),
					'msg' => 'success',
					'file_name' => $this->CI->upload->file_name 
			);
			return $data;
		}
	}
	
	/*
	 * codeigniter form validation을 위한 함수
	 */
	// 날자형식체크 (YYYY-MM-DD)
	function checkDate($text) {
		return preg_match("/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/", $text);
	}
	
	// URL형식 체크 http:// https:// ftp://
	function checkUrl($text) {
		return preg_match("/^(http|https|ftp):\/\/[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9](\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9])*(\.[a-zA-Z]+){1,2}(\/([\w#!:.?+=&%@!\-\/])*)?$/", $text);
	}
	
	// 돈형식 체크 (100000 or 100,000 or -100,000)
	function checkMoney($text, $sign = '') {
		return ($sign == '') ? preg_match("/^\d{1,3}(,?\d{3})*(\.\d+)?$/", $text) : preg_match("/^[-+]?\d{1,3}(,?\d{3})*(\.\d+)?$/", $text);
	}
	
	// json 호출시 오류인경우 메시지 출력 함수
	function printJsonErrorMessage($msg) {
		$response_type = 'fail';
		$response_data = $msg;
		echo json_encode(array (
				'response_type' => $response_type,
				'response_data' => $response_data 
		));
		$this->yield = false;
		exit();
	}

}