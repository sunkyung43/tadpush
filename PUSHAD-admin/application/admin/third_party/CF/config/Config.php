<?php
/**
 * Coffee Framework
 *
 * PHP Version 5.3
 *
 * LICENSE
 *
 * 본 프로그램은 New BSD License 를 기본으로 하고 있지만 약간 다른 제약조건을 가지고 있습니다. 
 * 함께 제공된 license file 인  doc/LICENSE 를 꼭 확인하시길 바랍니다.
 *
 * This Source is subject to the New BSD License with SOME CONSTRAINT that is boudled
 * with this package in the file doc/LICENSE 
 *
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: Config.php 19 2012-06-17 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config;

use Countable,
	Iterator;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class Config implements Countable, Iterator
{

// {{{ properties 
	/** @var array */
	private $data;

	/** @var array */
	private $attributes;

	/** @var datum for xml attribute */
	private $value = null;

	/** @var integer */
	private $_index;

	/** @var integer */
	private $_count;

	/** @var boolean */
	private $_unsetted = false;
// }}}


// {{{ Constructor ([mixed input [, mixed section [, null|string type [, integer option]]]]) 
	/**
	 * Constructor
	 *
	 * @param	null|array|string	input
	 * @param	null|array|string	section
	 * @param	null|string			type
	 * @param	integer				option	for json
	 * @return	void
	 */
	public function __construct($input = null, $section = null, $type = null, $option = 0)
	{
		// filename or string
		if(is_string($input)) {
			$formats = array('ini' => 'INI',
							'xml' => 'XML',
							'yml' => 'YAML',
							'json' => 'JSON'
						);
			$type = isset($formats[$type]) ? $formats[$type] : 'YAML';

			$class = __NAMESPACE__.'\\reader\\'.$type;

			$reader = new $class ($input, $option);
			$input = $reader->getData();
		}

		if(!is_array($input)) $input = array();

		if($section && is_string($section))
			$section = array($section);

		$this->_index = 0;
		$this->data = array();

		foreach($input as $key => $value) {
			if($key === '@attribute@') {
				$this->setAttributes($value);
				continue;
			}

			if($key === '@value@') {
				$this->setValue($value);
				continue;
			}

			if(is_array($section) && !in_array($key, $section))
				continue;

			if(is_array($value)) $this->data[$key] = new self($value);
			else $this->data[$key] = $value;
		}

		$this->_count = count($this->data);
	}
// }}}


// {{{ mixed getAttribute (string name) 
	/**
	 * @param	string name	name is to lowercase
	 * @return	mixed
	 */
	public function getAttribute ($name)
	{
		if(!$name || !$this->attributes) return null;

		return isset($this->attributes[$name])
					? $this->attributes[$name] : null;
	}
// }}}

// {{{ array getAttributes (void) 
	/**
	 * @return array
	 */
	public function getAttributes ()
	{
		return is_array($this->attributes) ? $this->attributes : array();
	}
// }}}

// {{{ Config setAttribute (string name, mixed value) 
	/**
	 * @param	string	name
	 * @param	mixed	value
	 * @return	Config
	 */
	public function setAttribute ($name, $value)
	{
		if(!$name) return $this;

		if(!is_array($this->attributes))
			$this->attributes = array();
		$this->attributes[$name] = $value;

		return $this;
	}
// }}}

// {{{ Config setAttributes (array pairs) 
	/**
	 * @param	array pairs
	 * @return	Config
	 */
	public function setAttributes (array $pairs)
	{
		foreach($pairs as $key => $value)
			$this->setAttribute($key, $value);

		return $this;
	}
// }}}

// {{{ Config removeAttribute (string attribute) 
	/**
	 * @param	string attribute
	 * @return	Config
	 */
	public function removeAttribute ($attribute)
	{
		if(!is_string($attribute)) return $this;

		unset($this->attributes[$attribute]);
		if(!$this->attributes) $this->attributes = null;

		return $this;
	}
// }}}

// {{{ Config removeAllAttribute (void) 
	/**
	 * Remove all attribute data
	 *
	 * @return Config
	 */
	public function removeAllAttribute ()
	{
		$this->attributes = null;
		return $this;
	}
// }}}

// {{{ mixed getValue (void) 
	/**
	 * @return mixed
	 */
	public function getValue ()
	{
		return $this->value;
	}
// }}}

// {{{ Config setValue (datum value) 
	/**
	 * @param	mixed value
	 * @return	Config
	 */
	public function setValue ($value)
	{
		$this->value = $value;

		return $this;
	}
// }}}

// {{{ array toArray (void) 
	/**
	 * Config object to array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$array = array();
		foreach($this->data as $key => $value) {
			if($value instanceof self) 
				$array[$key] = $value->toArray();
			else $array[$key] = $value;
		}

		$attrs = $this->getAttributes();
		$eValue = $this->getValue();
		if($attrs) $array['@attribute@'] = $attrs;
		if($eValue) $array['@value@'] = $eValue;

		return $array;
	}
// }}}

// {{{ Config merge (Config|array data) 
	/**
	 * Merge config object
	 *
	 * @param	Config|array data
	 * @return	Config
	 */
	public function merge($data)
	{
		if(is_array($data))
			$data = new self($data);

		if(!$data instanceof self)
			return $this;

		foreach($data as $key => $value) {
			if(array_key_exists($key, $this->data)) {
				if(is_int($key))
					$this->data[] = $value;
				elseif($value instanceof self && $this->data[$key] instanceof self)
					$this->data[$key]->merge($value);
				else $this->data[$key] = $value;
			}
			else $this->data[$key] = $value;
		}

		$this->attributes = array_merge($this->getAttributes(), $data->getAttributes());

		if($data->getValue()) $this->value = $data->getValue();

		$this->_count = count($this->data);

		return $this;
	}
// }}}

// {{{ void|string write (string filename, string type [, integer|string option]) 
	/**
	 * Write to file or return string
	 * If filename is null, returning raw data
	 *
	 * @param  string			filename
	 * @param  null|string		type		file format
	 * @param  integer|array	option		for json
	 * @return string|void
	 */
	public function write ($filename, $type = null, $option = null)
	{
		$formats = array('ini' => 'INI',
						'xml' => 'XML',
						'yml' => 'YAML',
						'json' => 'JSON',
						'php' => 'PHP'
					);

		$type = isset($formats[$type]) ? $formats[$type] : 'YAML';

		$class = __NAMESPACE__.'\\writer\\'.$type;

		if($filename === null)
			return (string) new $class(null, $this, $option);

		new $class($filename, $this, $option);
	}
// }}}

// {{{ string toString (string type [, integer|string option]) 
	/**
	 * Object data to string
	 *
	 * @param	string			type      data format
	 * @param	integer|array	option 
	 * @return	string
	 */
	public function toString ($type, $option = null)
	{
		return $this->write(null, $type, $option);
	}
// }}}

// {{{ integer index (void) 
	/**
	 * Returns current index
	 *
	 * @return integer
	 */
	public function index ()
	{
		return $this->_index;
	}
// }}}

// {{{ boolean exists (mixed value) 
	/**
	 * @param	mixed value
	 * @return	boolean
	 */
	public function exists ($value)
	{
		return in_array($value, $this->data);
	}
// }}}

// {{{ Config push (mixed value) 
	/**
	 * @param	mixed value
	 * @return	Config
	 */
	public function push ($value)
	{
		array_push($this->data, $value);
		$this->_count++;

		return $this;
	}
// }}}

// {{{ mixed pop (void) 
	/**
	 * @return mixed
	 */
	public function pop ()
	{
		$pop = array_pop($this->data);
		$this->_count = count($this->data);

		return $pop;
	}
// }}}

// {{{ mixed peak (void) 
	/**
	 * @return mixed
	 */
	public function peak ()
	{
		$data = end($this->data);
		$this->rewind();
		return $data;
	}
// }}}


// {{{ magic methods 
	// {{{ get 
	/**
	 * __get magic method
	 *
	 * @param	string name
	 * @return	mixed
	 */
	public function __get($name)
	{
		$result = null;
		if(array_key_exists($name, $this->data))
			$result = $this->data[$name];

		return $result;
	}
	// }}}
	// {{{ set 

	/**
	 * __set magic method
	 *
	 * @param	string	name
	 * @param	mixed	value
	 * @return	void
	 */
	public function __set($name, $value)
	{
		if(is_array($value)) 
			$this->data[$name] = new self($value);
		else $this->data[$name] = $value;

		$this->_count = count($this->data);
	}
	// }}}
	// {{{ isset 

	/**
	 * __isset magic method
	 *
	 * @param	string name
	 * @return	boolean
	 */
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}
	// }}}
	// {{{ unset 

	/**
	 * __unset magic method
	 *
	 * @param	string name
	 * @return	void
	 */
	public function __unset($name)
	{
		if($this->__isset($name)) {
			unset($this->data[$name]);
			$this->_count = count($this->data);
			$this->_unsetted = true;
		}
	}
	// }}}
	// {{{ clone 

	/**
	 * __clone magic method
	 *
	 * @return void
	 */
	public function __clone()
	{
		$array = array();

		foreach ($this->data as $key => $value) {
			if($value instanceof self)
				$array[$key] = clone $value;
			else $array[$key] = $value;
		}

		$this->data = $array;
	}
	// }}}
	// {{{ toString 

	/**
	 * __toString magic method
	 *
	 * @return string
	 */
	public function __toString()
	{
		return __CLASS__.' Object';
	}
	// }}}
// }}}

// {{{ Iterator interface 
	// {{{ current 
	/**
	 * Implement from Iterator
	 *
	 * @return mixed
	 */
	public function current()
	{
		$this->_unsetted = false;
		return current($this->data);
	}
	// }}}
	// {{{ key 

	/**
	 * Implement from Iterator
	 *
	 * @return string|integer
	 */
	public function key()
	{
		return key($this->data);
	}
	// }}}
	// {{{ next 

	/**
	 * Implement from Iterator
	 *
	 * @return void
	 */
	public function next()
	{
		if($this->_unsetted) {
			$this->_unsetted = false;
			return;
		}

		next($this->data);
		$this->_index++;
	}
	// }}}
	// {{{ rewind 

	/**
	 * Implement from Iterator
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->_unsetted = false;
		reset($this->data);
		$this->_index = 0;
	}
	// }}}
	// {{{ valid 

	/**
	 * Implement from Iterator
	 *
	 * @return boolena
	 */
	public function valid()
	{
		return $this->_index < $this->_count;
	}
	// }}}
// }}}

// {{{ countable Interface 
	// {{{ count 
	/**
	 * Implement from Countable
	 *
	 * @return integer
	 */
	public function count()
	{
		return $this->_count;
	}
	// }}}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
