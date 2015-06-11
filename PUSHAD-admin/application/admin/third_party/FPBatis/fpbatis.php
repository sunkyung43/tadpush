<?php

/**
 * Class: FPBatis - F(aux)P(hp)Batis
 * Credit: Adam Doyle (adamldoyle@gmail.com)
 * Purpose: To provide a semi-port of iBatis for Java.
 *
 * This class is far from a full-fledged port of iBatis; however, it does
 * provide support for some of the finer features of iBatis.  Currently
 * FPBatis only supports MySQL databases (due to me not needing it to use
 * on other types of databases).  Some of the more intricate features are
 * not accounted for (but could be in the future).
 *
 * Every effort has been made to keep the XML files in the proper structure
 * according to the DTD, although many of the features are never used.
 *
 * For a full class description/usage tips, please refer to:
 * http://code.google.com/p/fpbatis/
 */

class FPBatis {

	private $sqlMap; // Filename for the main sqlMap file
	private $conn; // Database connection
	private $xmlDoc; // Loaded sqlMap file
	private $namespaces; // Associate array of namespace files
	private $debug; // Display all SQL statements

	private $_trans_status	= TRUE; // Used with transactions to determine if a rollback should occur
	private $_trans_depth	= 0;

	private $is_connect = FALSE;

	private $field_list = array();

	/**
	 * Set-up the initial variables, create the initial connection (if
	 * desired), and load up the individual sql namespace files.
	*/
	function __construct($map) {
		$this->sqlMap = $map;
		$this->conn = null;
		$this->xmlDoc = new DOMDocument();
		$this->xmlDoc->load($this->sqlMap);
		$this->buildNamespaces();
		$this->debug = false;
		
		$CI = &get_instance();
		$this->conn = $CI->db->conn_id;
		if($this->conn)
		{
			$this->is_connect = true;
		}
		else
		{
			$this->is_connect = FALSE;
			throw new Exception('Unable to connect to database.');
		}
	}

	function getSqlMap() {
		return $this->sqlMap;
	}

	function getConnection() {
		return $this->conn;
	}

	function setDebug($debug) {
		$this->debug = $debug;
	}

	function trans_start()
	{
		// When transactions are nested we only begin/commit/rollback the outermost ones
		$this->_trans_depth += 1;
		if ($this->_trans_depth > 1)
		{
			return;
		}

		$this->_query('SET AUTOCOMMIT=0');
		$this->_query('START TRANSACTION'); // can also be BEGIN or BEGIN WORK
	}

	function trans_complete()
	{
		// When transactions are nested we only begin/commit/rollback the outermost ones
		$this->_trans_depth -= 1;
		if ($this->_trans_depth > 0)
		{
			return TRUE;
		}

		// The query() function will set this flag to FALSE in the event that a query failed
		if ($this->_trans_status === FALSE)
		{
			$this->trans_rollback();
			log_message('error', 'DB Transaction Failure');
			$this->display_error('DB Transaction Failure');
			return FALSE;
		}

		$this->trans_commit();
		return TRUE;
	}

	function trans_status()
	{
		return $this->_trans_status;
	}

	function trans_commit()
	{
		$this->_query('COMMIT');
		$this->_query('SET AUTOCOMMIT=1');
		return TRUE;
	}

	function trans_rollback()
	{
		$this->_query('ROLLBACK');
		$this->_query('SET AUTOCOMMIT=1');
		$this->_trans_status = TRUE;
		return TRUE;
	}

	function doSelectOne($id, $params=null, $fromForm=false, $debug=false) {
		return $this->doSelect($id, $params, $fromForm, false, $debug);
	}

	function doSelectList($id, $params=null, $fromForm=false, $debug=false) {
		return $this->doSelect($id, $params, $fromForm, true, $debug);
	}

	private function _get_sql($elm, $params, $fromForm = FALSE)
	{
		$stmt = $elm->nodeValue;
		$parameterClass = $elm->getAttribute('parameterClass');

		$stmt = $this->buildUpStatement($elm, $params, $parameterClass);

		$pieces = explode("$", $stmt);
		if (sizeof($pieces)>1) {
			$stmt = $pieces[0];
			for ($i = 1; $i < sizeof($pieces); $i+=2) {
				if ($fromForm) {
					$data = $this->param($pieces[$i]);
				}
				else {
					$data = $this->_get_param_data($elm, $params, $pieces[$i], $parameterClass);
				}
				$stmt .= "" . $data . "" . $pieces[$i+1];
			}
		}

		$pieces = explode("#", $stmt);
		if (sizeof($pieces)>1) {
			$stmt = $pieces[0];
			for ($i = 1; $i < sizeof($pieces); $i+=2) {
				if ($fromForm) {
					$data = $this->param($pieces[$i]);
				}
				else {
					$data = $this->_get_param_data($elm, $params, $pieces[$i], $parameterClass);
				}
				$stmt .= "'" . $data . "'" . $pieces[$i+1];
			}
		}

		$pieces = explode("@", $stmt);
		if (sizeof($pieces)>1) {
			$stmt = $pieces[0];
			$CI = &get_instance();
			for ($i = 1; $i < sizeof($pieces); $i+=2) {
				$data = $CI->lang->line($pieces[$i]);
				$stmt .= "'" . $data . "'" . $pieces[$i+1];
			}
		}
		
		return $stmt;
	}

	private function _get_param_data($elm, $params, $param_id, $class)
	{
		if (class_exists($class))
		{
			$method = 'get_' .strtolower($param_id);
			if(method_exists($params, $method))
			{
				return $params->$method();
			}
			else
			{
				log_message('error', "$method method is not exists");
				$this->display_error("$method method is not exists");
				return '';
			}
		}
		else if($class == 'array')
		{
			if(!empty($param_id) && isset($params[$param_id]))
			{
				return $params[$param_id];
			}
			else
			{
				return '';
			}
		}
		else
		{
			return $params;
		}
	}

	private function _set_param_data($elm, &$params, $param_id, $value, $class)
	{
		if (class_exists($class))
		{
			$method = 'set_' .strtolower($param_id);
			if(method_exists($params, $method))
			{
				$params->$method($value);
			}
			else
			{
				log_message('error', "$method method is not exists");
				$this->display_error("$method method is not exists");
			}
		}
		else if($class == 'array')
		{
			$params[$param_id] = $value;
		}
		else
		{
			$params = $value;;
		}
	}

	private function _query($sql, $id='')
	{
		if(!$this->is_connect)
		{
			return FALSE;
		}

		log_message('info', sprintf('DB QUERY[%s] : %s', $id, $sql));
		if ($this->debug)
			echo 'DEBUG: ' . $sql . '<br/>';

		// Run the Query
		if (FALSE === ($result = @mysql_query($sql, $this->conn)))
		{
			// This will trigger a rollback if transactions are being used
			$this->_trans_status = FALSE;

			// grab the error number and message now, as we might run some
			// additional queries before displaying the error
			$error_no = mysql_errno($this->conn);
			$error_msg = mysql_error($this->conn);

			// Log and display errors
			log_message('error', 'Query error: '.$error_msg);
			$this->display_error('Query error: '.$error_msg);

			return FALSE;
		}

		return $result;
	}

	private function _get_select_one_result($result, $resultTagsArry, $class_name, $field_list)
	{
		$num_rows = mysql_numrows($result);

		if($num_rows <= 0)
		{
			return null;
		}
		else if($num_rows > 1)
		{
			log_message('error', "Expected one result (or null) to be returned by selectOne(), but found: $num_rows");
			$this->display_error("Expected one result (or null) to be returned by selectOne(), but found: $num_rows");
			return null;
		}

		if($class_name == '')
		{
			return $this->_get_result_array($result, $resultTagsArry, $field_list);
		}
		else
		{
			return $this->_get_result_bean($result, $resultTagsArry, $class_name, $field_list);
		}
	}

	private function _get_select_list_result($result, $resultTagsArry, $class_name, $field_list)
	{
		$num_rows = mysql_numrows($result);

		$results = array();
		if($class_name == '')
		{
			for($row_index=0; $row_index<$num_rows; $row_index++) {
				$results[] = $this->_get_result_array($result, $resultTagsArry, $field_list, $row_index);
			}
		}
		else
		{
			for($row_index=0; $row_index<$num_rows; $row_index++) {
				$results[] = $this->_get_result_bean($result, $resultTagsArry, $class_name, $field_list, $row_index);
			}
		}
		return $results;
	}

	private function _get_mysql_result($result, $row, $field, $field_list = array())
	{
		if(is_numeric($field))
		{
			return mysql_result($result, $row, $field);
		}
		else if(isset($field_list[$field]))
		{
			return mysql_result($result, $row, $field);
		}
		else
		{
			return mysql_result($result, $row, $field);
		}
	}

	private function _get_subquery_result($result, $row_index, $field_list, $resultTag)
	{
		$column = rtrim(trim($resultTag->getAttribute('column'),'{'),'}');
		if (strpos($column,'=') === false) {
			$param = $this->_get_mysql_result($result,$row_index,$column, $field_list);
			if($param == '')
			{
				return null;
			}
			return $this->doSelectOne($resultTag->getAttribute('select'), $param);
		} else {
			$columns = array();
			foreach (explode(',',$column) as $piece) {
				$colPieces = explode('=',$piece);
				$param = $this->_get_mysql_result($result,$row_index,$colPieces[1], $field_list);
				if($param == '')
				{
					return null;
				}
				$columns[$colPieces[0]] = $param;
			}
			return $this->doSelectOne($resultTag->getAttribute('select'), $columns);
		}
	}

	private function _get_result_array($result, $resultTagsArry, $field_list, $row_index = 0)
	{
		$resultElm = array();

		if(empty($resultTagsArry))
		{
			if(count($field_list) > 1) {
				log_message('error', "Expected one column to be returned by empty resultMap, but Column Count : " .count($field_list));
				$this->display_error("Expected one column to be returned by empty resultMap, but Column Count : " .count($field_list));
				return null;
			}

			return $this->_get_mysql_result($result,$row_index,0);
		}

		foreach ($resultTagsArry as $resultTags) {
			foreach ($resultTags as $resultTag) {
				if ($resultTag->getAttribute('select') == null) {
					$resultElm[$resultTag->getAttribute('property')] = $this->_get_mysql_result($result,$row_index,$resultTag->getAttribute('column'), $field_list);
				} else {
					$resultElm[$resultTag->getAttribute('property')] = $this->_get_subquery_result($result, $row_index, $field_list, $resultTag);
				}
				
				if(isset($field_list[$resultTag->getAttribute('column')])) {
					unset($field_list[$resultTag->getAttribute('column')]);
				}
			}
		}
		
		foreach($field_list as $field) {
			$resultElm[strtolower($field)] = $this->_get_mysql_result($result,$row_index,$field);
		}
		
		return $resultElm;
	}

	private function _get_result_bean($result, $resultTagsArry, $class_name, $field_list, $row_index = 0)
	{
		if (!class_exists($class_name))
		{
			log_message('error', "$class_name class is not exists");
			$this->display_error("$class_name class is not exists");
			return null;
		}

		$bean = new $class_name();
		foreach ($resultTagsArry as $resultTags) {
			foreach ($resultTags as $resultTag) {
				$c = $resultTag->getAttribute('column');
				$v = $this->_get_mysql_result($result,$row_index,$resultTag->getAttribute('column'), $field_list);

				if ($resultTag->getAttribute('select') == null) {
					$property = $resultTag->getAttribute('property');
					$column = $this->_get_mysql_result($result,$row_index,$resultTag->getAttribute('column'), $field_list);
					$this->_set_bean_data($bean, $property, $column);
				} else {
					$property = $resultTag->getAttribute('property');
					$column = $this->_get_subquery_result($result, $row_index, $field_list, $resultTag);
					$this->_set_bean_data($bean, $property, $column);
				}
				
				if(isset($field_list[$resultTag->getAttribute('column')])) {
					unset($field_list[$resultTag->getAttribute('column')]);
				}
			}
		}
		
		foreach($field_list as $field) {
			$column = $this->_get_mysql_result($result,$row_index,$field);
			$this->_set_bean_data($bean, $field, $column);
		}
		
		return $bean;
	}

	private function _set_bean_data(&$bean, $property, $column)
	{
		$method = 'set_' .strtolower($property);
		if(method_exists($bean, $method))
		{
			$bean->$method($column);
		}
		else
		{
			log_message('error', "$method method is not exists");
			$this->display_error("$method method is not exists");
		}
	}

	private function display_error($error = '', $swap = '', $native = TRUE)
	{
		$CI = &get_instance();
		if(!$CI->db->db_debug)
		{
			return;
		}
		
		$LANG =& load_class('Lang', 'core');
		$LANG->load('db');

		$heading = $LANG->line('db_error_heading');

		if ($native == TRUE)
		{
			$message[] = $error;
		}
		else
		{
			$message = ( ! is_array($error)) ? array(str_replace('%s', $swap, $LANG->line($error))) : $error;
		}

		// Find the most likely culprit of the error by going through
		// the backtrace until the source file is no longer in the
		// database folder.

		$trace = debug_backtrace();

		foreach ($trace as $call)
		{
			if (isset($call['file']) && strpos($call['file'], BASEPATH.'database') === FALSE)
			{
				// Found it - use a relative path for safety
				$message[] = 'Filename: '.str_replace(array(BASEPATH, APPPATH), '', $call['file']);
				$message[] = 'Line Number: '.$call['line'];

				break;
			}
		}

		$error =& load_class('Exceptions', 'core');
		echo $error->show_error($heading, $message, 'error_db');
		// exit;
	}

	/**
	 * Parse the main sqlMap for the database properties and create a
	 * database connection.
	 */
	function createConnection() {
		// 현재는 사용 안함.
		set_status_header(500);

		if($this->is_connect)
		{
			set_status_header(200);
			return;
		}
		
		$propertyTags = $this->xmlDoc->getElementsByTagName('property');
		$properties = array();
		foreach ($propertyTags as $tag) {
			$properties[$tag->getAttribute('name')] = $tag->getAttribute('value');
		}
		$serverSpecs = explode('/', $properties['JDBC.ConnectionURL']);
		$server = explode(':',$serverSpecs[2]);
		$this->conn = @mysql_connect($server[0], $properties['JDBC.Username'], $properties['JDBC.Password']) or die('');
		if (!empty($serverSpecs[3]))
			mysql_select_db($serverSpecs[3], $this->conn) or die('');

		$this->is_connect = TRUE;
		set_status_header(200);
	}

	/**
	 * Parse the main sqlMap for the list of sub-maps (by namespace) and
	 * add the loaded files to the namespaces array for easy access.
	 */
	function buildNamespaces() {
		$sqlMapConfig = $this->xmlDoc->getElementsByTagName('sqlMapConfig');
		$sqlMapConfig = $sqlMapConfig->item(0);

		// jwpark 경로 수정
		// 		if (strrpos($this->sqlMap, '/') !== false)
		// 			$dir = substr($this->sqlMap, 0, strrpos($this->sqlMap, '/')+1);
		// 		else
		$dir = '';
		$maps = $sqlMapConfig->getElementsByTagName('sqlMap');
		foreach($maps as $map) {
			$ext = $dir . $map->getAttribute('resource');
			$tempDoc = new DomDocument();
			$tempDoc->load($ext, LIBXML_NOCDATA);
			$node = $tempDoc->getElementsByTagName('sqlMap')->item(0);
			$this->namespaces[$node->getAttribute('namespace')] = $node;
		}
	}

	/**
	 * Given a namespace, tag name, and id, it returns the XML node (null
	 * if not found).
	 */
	function findMapElement($namespace, $tagName, $id) {
		$map = $this->namespaces[$namespace];
		if ($map != '') {
			foreach ($map->getElementsByTagName($tagName) as $elem) {
				if ($elem->getAttribute('id') == $id) {
					return $elem;
				}
			}
		}
		return null;
	}

	function applyDynamicElement($item, $params, $dynamic, $parameterClass) {
		$stmt = '';
		if ($item->getAttribute('open') != null)
			$stmt .= ' ' . $item->getAttribute('open');
		if (!$dynamic && $item->getAttribute('prepend') != null)
			$stmt .= $item->getAttribute('prepend') . ' ';
		if ($item->nodeName == 'dynamic')
			$dynamic = true;
		$stmt .= $this->buildUpStatement($item, $params,$parameterClass, $dynamic);
		if ($item->getAttribute('close') != null)
			$stmt .= $item->getAttribute('close') . ' ';
		return $stmt;
	}

	function buildUpStatement($elm, $params, $parameterClass, $dynamic=false) {
		$childTags = array('#text','include','dynamic','iterate','isParameterPresent',
				'isNotParameterPresent','isEmpty','isNotEmpty','isNull','isNotNull',
				'isEqual','isNotEqual','isGreaterThan','isGreaterEqual','isLessThan',
				'isLessEqual','isPropertyAvailable','isNotPropertyAvailable');
			
		$stmt = '';
		foreach ($elm->childNodes as $item) {
			if(method_exists($item, 'getAttribute')) {
				$property = $item->getAttribute('property');
				$param_data = $this->_get_param_data($elm, $params, $property,$parameterClass);
			}
			switch($item->nodeName) {
				case '#text':
					if(preg_replace('/\s\s+/', '', $item->nodeValue) != '')
						// $stmt .= preg_replace('/\s\s+/', ' ', $item->nodeValue);
						$stmt .= $item->nodeValue;
					break;
				case 'dynamic':
					$subStmt = $this->buildUpStatement($item, $params,$parameterClass,true);
					if (preg_replace('/\s\s+/', '', $subStmt) != '') {
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'iterate':
					if (!empty($param_data)) {
						$subStmt = '';
							
						$paramList = $param_data;
						$size_list = sizeof($paramList);
						for ($i = 0; $i < $size_list; $i++) {
							$param = $paramList[$i];
							$this->_set_param_data($elm, $params, $property . '[]', $param,$parameterClass);
							$sub = $this->buildUpStatement($item, $params,$parameterClass, $dynamic);
							$pieces = explode("#", $item->nodeValue);
							if (sizeof($pieces)>1) {
								$sub = $pieces[0];
								for ($j = 1; $j < sizeof($pieces); $j+=2) {
									$data = $this->_get_param_data($elm, $params, $pieces[$j],$parameterClass);
									$sub .= "'" . $data . "'" . $pieces[$j+1];
								}
							}
							if ($item->getAttribute('conjunction') != null && $i != 0)
								$subStmt .= $item->getAttribute('conjunction');
							$subStmt .= $sub;
						}
							
						if ($subStmt != '') {
							if ($item->getAttribute('open') != null)
								$subStmt = $item->getAttribute('open') . $subStmt;
							if ($item->getAttribute('close') != null)
								$subStmt .= $item->getAttribute('close');
							if ($dynamic)
								$dynamic = false;
							else if ($item->getAttribute('prepend') != null)
								$stmt .= $item->getAttribute('prepend');
							$stmt .= $subStmt;
							if ($item->getAttribute('append') != null)
								$stmt .= $item->getAttribute('append');
							$dynamic = false;
						}
					}
					break;
				case 'isNotEmpty':
				case 'isParameterPresent':
				case 'isPropertyAvailable':
					if (!empty($param_data)) {
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isEmpty':
				case 'isNotParameterPresent':
				case 'isNotPropertyAvailable':
					if (empty($param_data)) {
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isNull':
					if ($param_data === null) {
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isNotNull':
					if ($param_data !== null) {
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isEqual':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data == $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isNotEqual':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data != $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isGreaterThan':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data > $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isGreaterEqual':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data >= $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isLessThan':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data < $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				case 'isLessEqual':
					$compareValue = $item->getAttribute('compareValue');
					if($param_data <= $compareValue)
					{
						$stmt .= $this->applyDynamicElement($item, $params, $dynamic,$parameterClass);
						$dynamic = false;
					}
					break;
				default:

					break;
			}
		}
		return $stmt;
	}

	/**
	 * Run the statement given by the id.
	 * Supports array and single variable parameterClasses, as well as
	 * linking sub-statements through the result declaration.
	 */
	function doSelect($id, $params=null, $fromForm=false, $resultTypeArray=true, $debug=false) {
		$ids = explode(".", $id);
		if ($elm = $this->findMapElement($ids[0], 'select', $ids[1])) {
			$resultMapID = $elm->getAttribute('resultMap');
			if($resultMapID != '')
			{
				if ($resultMap = $this->findMapElement($ids[0], 'resultMap', $resultMapID)) {
					$resultTagsArry[] = $resultMap->getElementsByTagName('result');
					while ($resultMap->getAttribute('extends') != null) {
						if ($resultMap = $this->findMapElement($ids[0], 'resultMap', $resultMap->getAttribute('extends'))) {
							$resultTagsArry[] = $resultMap->getElementsByTagName('result');
						}
					}

					$class_name = $resultMap->getAttribute('class') != null ? $resultMap->getAttribute('class') : '';

				}
				else
				{
					log_message('error', "Result Map not found. resultMap = $resultMapID");
					$this->display_error("Result Map not found. resultMap = $resultMapID");
					return null;
				}
			}
			else
			{
				$resultTagsArry = array();
				$class_name = '';
			}

			$stmt = $this->_get_sql($elm, $params, $fromForm);
// 			$stmt = str_replace("\r\n"," ",$stmt);
// 			$stmt = str_replace("\n"," ",$stmt);
			
			// 				$result = mysql_query($stmt, $this->conn) or die('There was an error running your SQL statement: ' . $stmt);
			if (FALSE === ($result = $this->_query($stmt, $id)))
			{
				return null;
			}

			$field_num = mysql_num_fields($result);
			$field_list = array();
			for($field_offset = 0; $field_offset < $field_num; $field_offset++)
			{
				$field_list[mysql_field_name($result, $field_offset)] = mysql_field_name($result, $field_offset);
			}

			if($resultTypeArray)
			{
				return $this->_get_select_list_result($result, $resultTagsArry, $class_name, $field_list);
			}
			else
			{
				return $this->_get_select_one_result($result, $resultTagsArry, $class_name, $field_list);
			}
		}
		else
		{
			log_message('error', "select query id not found. id = $id");
			$this->display_error("select query id not found. id = $id");
			return null;
		}
		return null;
	}

	/**
	 * Perform an insert given an array of variables and an insert id to
	 * use, returns the object back (null if incorrect id).
	 */
	function doInsert($id, $obj, $fromForm=false) {
		$ids = explode(".", $id);
		if ($elm = $this->findMapElement($ids[0], 'insert', $ids[1])) {
			$elm = $elm->cloneNode(true);
			if ($subStmt = $elm->getElementsByTagName('selectKey')->item(0)) {
				$elm->removeChild($subStmt);
			}

			$stmt = $this->_get_sql($elm, $obj, $fromForm);
			// 			mysql_query($stmt, $this->conn) or die('There was an error running your SQL statement: ' . $stmt);
			if (FALSE === ($result = $this->_query($stmt, $id)))
			{
				return null;
			}

			if ($subStmt != null) {
				// 				$result = mysql_query($subStmt->nodeValue, $this->conn) or die('There was an error running your SQL statement: ' . $subStmt->nodeValue);
				if (FALSE === ($result = $this->_query($subStmt->nodeValue)))
				{
					return null;
				}

				if($subStmt->getAttribute('keyProperty') != '') {
					$obj[$subStmt->getAttribute('keyProperty')] = $this->_get_mysql_result($result,0,0);
				} else {
					return $this->_get_mysql_result($result,0,0);
				}
			}
			return $obj;
		}
		return null;
	}

	/**
	 * Similar to insert, but for updates.
	 */
	function doUpdate($id, $obj, $fromForm=false) {
		$ids = explode(".", $id);
		if ($elm = $this->findMapElement($ids[0], 'update', $ids[1])) {
			$stmt = $this->_get_sql($elm, $obj, $fromForm);
			// 			mysql_query($stmt, $this->conn) or die('There was an error running your SQL statement: ' . $stmt);
			if (FALSE === ($result = $this->_query($stmt, $id)))
			{
				return null;
			}

			return $obj;
		}
		return null;
	}

	/**
	 * Similar to insert, but for deletes. Returns true if successful,
	 * null if id not valid.
	 */
	function doDelete($id, $obj) {
		$ids = explode(".", $id);
		if ($elm = $this->findMapElement($ids[0], 'delete', $ids[1])) {
			$stmt = $this->_get_sql($elm, $obj);
			// 			mysql_query($stmt, $this->conn) or die('There was an error running your SQL statement: ' . $stmt);
			if (FALSE === ($result = $this->_query($stmt, $id)))
			{
				return null;
			}

			return true;
		}
		return null;
	}

	/**
	 * Given an array, a primary key and a value to compare against, this
	 * performs either an insert or an update.
	 */
	function doSave($namespace, $obj, $key='id', $insertId='insert', $updateId='update', $newValue=-1) {
		if ($obj[$key] == $newValue || $obj[$key] == '')
			return $this->doInsert($namespace . '.' . $insertId,$obj);
		else
			return $this->doUpdate($namespace . '.' . $updateId,$obj);
	}

	function doSaveForm($namespace, $key='id', $insertId='insert', $updateId='update', $newValue=-1) {
		if ($this->param($key) == $newValue || $this->param($key) == '')
			return $this->doInsert($namespace . '.' . $insertId,array(),true);
		else
			return $this->doUpdate($namespace . '.' . $updateId,array(),true);
	}

	function &customQuery($stmt) {
		// 		$result =& mysql_query($stmt, $this->conn) or die('There was an error running your SQL statement: ' . $stmt);
		if (FALSE === ($result =& $this->_query($stmt)))
		{
			return null;
		}

		return $result;
	}

	function &customSelect($stmt, $type=MYSQL_ASSOC) {
		$result =& $this->customQuery($stmt);
		$results = array();
		while ($row = mysql_fetch_array($result, $type)) {
			$results[] = $row;
		}
		return $results;
	}

	function param($Name) {
		global $HTTP_GET_VARS;
		global $HTTP_POST_VARS;

		if(isset($HTTP_GET_VARS[$Name]))
			return($HTTP_GET_VARS[$Name]);
			
		if(isset($HTTP_POST_VARS[$Name]))
			return($HTTP_POST_VARS[$Name]);
			
		return("");
	}
}
