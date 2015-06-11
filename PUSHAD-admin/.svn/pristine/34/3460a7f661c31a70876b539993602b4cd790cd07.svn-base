<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ui_component {

	function __construct() {
	}

	public function create_time_selectbox($select_id, $selected_value = '', $min_time = 0) {
		$option_array = array ();
		for($i = $min_time; $i < 24; $i++) {
			$option_array[sprintf('%02d:00:00', $i)] = sprintf('%02d:00', $i);
		}
		return $this->create_selectbox($select_id, $option_array, $selected_value, '선택해주세요');
	}

	public function create_creative_selectbox($select_id, $option_array, $selected_value = '', $default_value = '', $onchange = '') {
		return $this->create_selectbox($select_id, $option_array, $selected_value, $default_value, $onchange, 'style="margin-right: 10px"');
	}

	public function create_selectbox($select_id, $option_array, $selected_key = '', $default_value = '', $onchange = '', $style = '') {
		if ($onchange != '') {
			$onchange = sprintf('onchange="%s"', $onchange);
		}
		
		$return_html = sprintf('<select id="%s" name="%s" %s %s>', $select_id, $select_id, $onchange, $style);
		
		if ($default_value != '') {
			$selected = $selected_key == '' ? 'selected' : '';
			$return_html .= sprintf('<option value="%s" %s>%s</option>', '', $selected, $default_value);
		}
		
		foreach ( $option_array as $key => $value ) {
			$selected = $selected_key == $key ? 'selected' : '';
			$return_html .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $value);
		}
		
		$return_html .= '</select>';
		
		return $return_html;
	}

	public function create_media_list($media_list) {
		$html = '';
		foreach ( $media_list as $row ) {
			$html .= sprintf('<tr id="%s" class="ui-selectee">', $row['media_id']);
			$html .= sprintf('<td class="ui-selectee">%s</td>', $row['media_nm']);
			$html .= sprintf('<td class="ui-selectee">%s</td>', $row['media_id']);
			$html .= '</tr>';
		}
		return $html;
	}

	public function create_radio_button($radio_name, $radio_array, $class_name = '', $checked_key = '', $default_value = '') {
		$return_html = '';
		
		if ($default_value != '') {
			$checked = '' == $checked_key ? 'checked="checked"' : '';
			$return_html .= sprintf('<input type="radio" id="%s" name="%s" class="radioBtn %s" value="" %s />', $radio_name . '_dummy', $radio_name, $class_name, $checked);
			$return_html .= sprintf('<label>%s</label>&nbsp;&nbsp;', $default_value);
		}

		foreach ( $radio_array as $key => $val ) {
			$checked = $key == $checked_key ? 'checked="checked"' : '';
			$return_html .= sprintf('<input type="radio" id="%s" name="%s" class="radioBtn %s" value="%s" %s />', $radio_name . '_' . $key, $radio_name, $class_name, $key, $checked);
			$return_html .= sprintf('<label>%s</label>&nbsp;&nbsp;', $val);
		}
		
		return $return_html;
	}

}

/* End of file ui_component.php */
/* Location: ./application/admin/libraries/ui_component.php */
