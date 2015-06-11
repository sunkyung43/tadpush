<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  =======================================
*  Author     : Muhammad Surya Ikhsanudin
*  License    : Protected
*  Email      : mutofiyah@gmail.com
*
*  Dilarang merubah, mengganti dan mendistribusikan
*  ulang tanpa sepengetahuan Author
*  =======================================
*/
require_once APPPATH."third_party/PHPExcel.php";

class Excel extends PHPExcel
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_excel_template_list($file_path)
	{
		$data = PHPExcel_IOFactory::load($file_path);

		$sheet = $data->getSheet();

		$highest_row = $sheet->getHighestRow();
		if($highest_row < 2)
		{
			$data->disconnectWorksheets();
			unset($data);

			return array();
		}

		$device_template = array();
		for($row = 2; $row <= $highest_row; $row++)
		{
			if($sheet->getCellByColumnAndRow(0, $row)->getValue() != '')
			{
				$device_template[] = $sheet->getCellByColumnAndRow(0, $row)->getValue();
			}
		}

		$data->disconnectWorksheets();
		unset($data);

		return $device_template;
	}

	private function _set_active_sheet($sheet_index)
	{
		$this->setActiveSheetIndex($sheet_index); // 활성화할 시트 번호 설정
	}
	
	private function _set_sheet_title($sheet_nm)
	{
		if ($sheet_nm != '')
		{
			$this->getActiveSheet()->setTitle($sheet_nm);
		}
	}
	
	private function _set_title($column_list, $column_index, $cell_index)
	{
		$style = array(
				'font' => array(
						'bold' => true,
						'size' => 8.5
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'D5D5D5')
				),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
	
		foreach($column_list as $title => $column)
		{
			$this->getActiveSheet()->getStyle($column_index.$cell_index)->applyFromArray($style);
			$this->getActiveSheet()->setCellValue($column_index.$cell_index, $title);
	
			$column_index = chr(ord($column_index) + 1);
		}
	}
	
	private function _set_data_list($column_list, $data_list, $column_start, &$cell_index, $check_fill = false)
	{
		if(!is_array($data_list)) {
			return;
		}
		
		foreach($data_list as $row)
		{
			if($check_fill !== false) {
				$fill = $this->_is_column_fill($row);
			} else {
				$fill = '0';
			}
			
			$column_index = $column_start;
			foreach($column_list as $title => $column)
			{
				$value = '';
				$method = 'get_' .$column;
				if(method_exists($row, $method))
				{
					$value = $row->$method();
				}
				else if (is_array($row) && isset($row[$column]))
				{
					$value = $row[$column];
				}
				else
				{
					log_message('error', "$method method is not exists");
				}
				$this->_set_data($column_index, $cell_index, $value, false, $fill);
				$column_index = chr(ord($column_index) + 1);
			}
			$cell_index++;
			// 			log_message('info', "cell_index=$cell_index");
			// 			log_message('info', "excel memory=" .$this->convert(memory_get_usage(true)));
		}
	}
	
	private function _is_column_fill($row) {
		$method = 'get_target';
		if(method_exists($row, $method))
		{
			$fill = $row->$method();
		}
		else if (is_array($row) && isset($row['target']))
		{
			$fill = $row['target'];
		}
		return $fill;
	}
	
	function convert($size){
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	private function _set_data($column_index, $cell_index, $value, $bold=false, $fill='0')
	{
		$style = array(
				'font' => array(
						'size' => 8
				),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
	
		if($fill == '1')
		{
			$style['fill'] = array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'D5D5D5')
			);
				
		}
		
		if($value == '')
		{
			$value = '-';
		}
		if($bold)
		{
			$style['font']['bold'] = true;
		}
		$this->getActiveSheet()->getStyle($column_index.$cell_index)->applyFromArray($style);
		$this->getActiveSheet()->setCellValueExplicit($column_index.$cell_index, $value, PHPExcel_Cell_DataType::TYPE_STRING);
	}
	
	private function _draw_border($column_start, $column_end, $cell_start, $cell_end)
	{
		$this->getActiveSheet()->getStyle($column_start.$cell_start.':'.$column_end.$cell_end)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->getActiveSheet()->getStyle($column_start.$cell_start.':'.$column_end.$cell_end)->getBorders()->getAllBorders()->getColor()->setARGB("FF5D5D5D");
	}
	
	private function _save_excel($file_nm)
	{
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' .$file_nm .'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
	
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');    //if you want to save it as .XLSX Excel 2007 format
		$objWriter->save('php://output');    //force user to download the Excel file without writing it to server's HD
	
		log_message('info', "excel memory=" .$this->convert(memory_get_usage(true)));
	}
	
	function export_excel($file_nm, $sheet_nm, $column_list, $data_list)
	{
		if(!is_array($column_list))
		{
			log_message('error', "export excel error. (column is Empty)");
			return;
		}
	
		$cell_index     = 1;    // cell 초기번호
		$column_start = 'A';
	
		// 시트명
		$this->_set_active_sheet(0);
		$this->_set_sheet_title($sheet_nm);
	
		// 타이틀
		$column_index = $column_start;
		$this->_set_title($column_list, $column_index, $cell_index);
		$cell_index++;
	
		// 리스트
		$this->_set_data_list($column_list, $data_list, $column_start, $cell_index);
	
		// 표 테두리
		$cell_index--;
		$column_end = chr(ord($column_start) + count($column_list) - 1);
		$this->_draw_border($column_start, $column_end, 1, $cell_index);
	
		// 파일 명
		$this->_save_excel($file_nm);
	
	}
	
	function export_target_report_excel($file_nm, $sheet_nm, $column_list, $data_list)
	{
		if(!is_array($column_list) || !is_array($data_list))
		{
			log_message('error', "export excel error. (List is Empty)");
			return;
		}
		
		$cell_index     = 1;    // cell 초기번호
		$column_start = 'A';
		
		// 시트명
		$this->_set_active_sheet(0);
		$this->_set_sheet_title($sheet_nm);
		
		// 타이틀
		$column_index = $column_start;
		$this->_set_title($column_list, $column_index, $cell_index);
		$cell_index++;
		
		// 리스트
		$this->_set_data_list($column_list, $data_list, $column_start, $cell_index, true);
		
		// 표 테두리
		$cell_index--;
		$column_end = chr(ord($column_start) + count($column_list) - 1);
		$this->_draw_border($column_start, $column_end, 1, $cell_index);
		
		// 파일 명
		$this->_save_excel($file_nm);		
	}

}
