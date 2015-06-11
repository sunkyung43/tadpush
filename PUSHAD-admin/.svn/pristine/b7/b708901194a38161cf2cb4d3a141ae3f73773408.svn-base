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
 * @package    CF_loader
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: Autoloader.php 8 2012-05-18 ccooffeee Exp $
 */


/** @namespace */
namespace CF\loader;


use CF\exception\InvalidArgumentException,
	Traversable;


/**
 * Autoloader
 *
 * Allows namespaces and prefix class
 *
 * @category   CF
 * @package    CF_loader
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class Autoloader
{

// {{{ properties
	/** @var array namespace/directory pairs */
	private $namespaces = array();

	/** @var array prefix/directory pairs */
	private $prefixes = array();

	/** @var array class maps */
	private $classMap = array();

	/** @var boolean fallback autoloader flag */
	private $fallback = false;
// }}}


// {{{ constructor (null|array|Traversable options) 
	/** Constructor
	 *
	 * @param	null|array|Traverable options
	 * @return	void
	 */
	public function __construct ($options = null)
	{
		$this->setNamespace('CF', dirname(__DIR__));

		if($options !== null)
			$this->setOptions($options);

		$this->register();
	}
// }}}


	// {{{ Autoloader setOptions (array|Traversable options) 
	/** Configure autoloader
	 *
	 * Allow the namespace and prefix
	 * following structure:
	 * <code>
	 * array(
	 * 	'namespace' => array(
	 *			'CF' => '/path/to/CF_library',
	 *			'vendor' => '/path/to/vendors_path'
	 *		),
	 *	'prefix' => array(
	 *			'mylib_' => '/path/to/mylib/libpath'
	 *		),
	 *	'class' => array(
	 *			'My_Apps_Class' => '/app_directory/my_app.php'
	 *		),
	 *	'fallback' => true
	 * )
	 * </code>
	 *
	 * @param	array|Traversable options
	 * @return	Autoloader
	 * @throws	CF\exception\InvalidArgumentException
	 */
	public function setOptions ($options)
	{
		if(!is_array($options) && !($options instanceof Traversable)) {
			require_once dirname(__DIR__).'/exception/InvalidArgumentException.php';
			throw new InvalidArgumentException('Options must be array or Traversable');
		}

		foreach($options as $type => $value) {
			switch($type) {
				case 'namespace':
					if(is_array($value) || $value instanceof Traversable)
						$this->setNamespaces($value);
					break;
				case 'prefix':
					if(is_array($value) || $value instanceof Traversable)
						$this->setPrefixes($value);
					break;
				case 'class':
					if(is_array($value) || $value instanceof Traversable)
						$this->setClassMap($value);
					break;
				case 'fallback':
					$this->setFallback($value);
					break;
			}
		}

		return $this;
	}
	// }}}

	// {{{ Autoloader setNamespace (string namespace, string directory) 
	/** Set namespace/directory pair
	 *
	 * @param	string namespace
	 * @param	string directory
	 * @return	Autoloader
	 */
	public function setNamespace ($namespace, $directory)
	{
		$namespace = rtrim($namespace, '\\').'\\';
		$this->namespaces[$namespace] = $this->normalize($directory);

		return $this;
	}
	// }}}

	// {{{ Autoloader setNamespaces (array|Traversable namespaces) 
	/** Set namespace pairs
	 *
	 * @param	array|Traversable namespaces
	 * @return	Autoloader
	 * @throws	CF\exception\InvalidArgumentException
	 */
	public function setNamespaces ($namespaces)
	{
		if(!is_array($namespaces) && !$namespaces instanceof Traversable) {
			require_once dirname(__DIR__).'/exception/InvalidArgumentException.php';
			throw new InvalidArgumentException('Namespace is must be array or Traversable');
		}

		foreach ($namespaces as $ns => $dir)
			$this->setNamespace($ns, $dir);

		return $this;
	}
	// }}}

	// {{{ Autoloader setPrefix (string prefix, string directory) 
	/**
	 * Set prefix/directory pair
	 *
	 * @param	string prefix
	 * @param	string directory
	 * @return	Autoloader
	 */
	public function setPrefix ($prefix, $directory)
	{
		$prefix = rtrim($prefix, '_').'_';
		$this->prefixes[$prefix] = $this->normalize($directory);

		return $this;
	}
	// }}}

	// {{{ Autoloader setPrefixes (array|Traversable prefixes) 
	/**
	 * Set prefix pairs
	 *
	 * @param	array|Traversable
	 * @return	Autoloader
	 * @throws	CF\exception\InvalidArgumentException
	 */
	public function setPrefixes ($prefixes)
	{
		if(!is_array($prefixes) && !$prefixes instanceof Traversable) {
			require_once dirname(__DIR__).'/exception/InvalidArgumentException.php';
			throw new InvalidArgumentException('Prefixe is must be array or Traversable');
		}

		foreach ($prefixes as $px => $dir)
			$this->setPrefix($px, $dir);

		return $this;
	}
	// }}}

	// {{{ Autoloader setClassMap (array|Traversable map) 
	/**
	 * Set className/directory pairs
	 *
	 * @param	array|Traversable
	 * @return	Autoloader
	 * @throws	CF\exception\InvalidArgumentException
	 */
	public function setClassMap ($map)
	{
		if(!is_array($map) && !$map instanceof Traversable) {
			require_once dirname(__DIR__).'/exception/InvalidArgumentException.php';
			throw new InvalidArgumentException('Class map is must be array or Traversable');
		}

		foreach ($map as $class => $file) {
			$file = stream_resolve_include_path($file);
			if($file !== false)
				$this->classMap[$class] = $file;
		}

		return $this;
	}
	// }}}

	// {{{ Autoloader setFallback (boolean flag) 
	/** set fallback flag
	 *
	 * @param	boolean flag
	 * @return	Autoloader
	 */
	public function setFallback ($flag)
	{
		$this->fallback = (bool) $flag;

		return $this;
	}
	// }}}

	// {{{ boolean isFallback (void) 
	/**
	 * Is actionable fallback?
	 *
	 * @return	boolean
	 */
	public function isFallback ()
	{
		return $this->fallback;
	}
	// }}}

	// {{{ false|string autoload (string class) 
	/** Definition the class autoloader
	 *
	 * @param	string class
	 * @return	false|string
	 */
	public function autoload ($class)
	{
		if(isset($this->classMap[$class])) {
			require $this->classMap[$class];
			return $class;
		}

		switch(true) {
			case strpos($class, '\\') !== false:
				if($this->loadClass($class, 'namespace'))
					return $class;
				break;
			case strpos($class, '_') !== false:
				if($this->loadClass($class, 'prefix'))
					return $class;
				break;
		}

		if($this->isFallback())
			return $this->loadClass($class, 'fallback');

		return false;
	}
	// }}}

	// {{{ void register (void) 
	/**
	 * Register autoload
	 *
	 * @return	void
	 */
	public function register ()
	{
		spl_autoload_register(array($this, 'autoload'));
	}
	// }}}

	// {{{ void unregister (void) 
	/**
	 * Unregister autoload
	 *
	 * @return void
	 */
	public function unregister ()
	{
		spl_autoload_unregister(array($this, 'autoload'));
	}
	// }}}


// {{{ private methods
	// {{{ string normalize (string directory) 
	/**
	 * Normalize directory to include directory separator
	 *
	 * @param	string directory
	 * @return	string
	 */
	private function normalize ($directory)
	{
		return rtrim($directory, '/\\').DIRECTORY_SEPARATOR;
	}
	// }}}

	// {{{ boolean loadClass (string class, string type) 
	/**
	 * Load a class
	 *
	 * @param	string class
	 * @param	string type
	 * @return	boolean
	 */
	private function loadClass ($class, $type)
	{
		if($type === 'fallback') {
			$filename = $this->classToFilename($class);
			$filename = stream_resolve_include_path($filename);
			if($filename !== false)
				return require $filename;

			return false;
		}

		$type = $type === 'prefix' ? $this->prefixes : $this->namespaces;

		foreach($type as $name => $dir) {
			if(strpos($class, $name) === 0) {
				$class = substr($class, strlen($name));
				$filename = $this->classToFilename($class, $dir);
				$filename = stream_resolve_include_path($filename);
				if($filename !== false)
					return require $filename;

				return false;
			}
		}

		return false;
	}
	// }}}

	// {{{ string classToFilename (string class, null|string directory) 
	/**
	 * Classname to filename
	 *
	 * @param	string class
	 * @param	null|string directory
	 * @return	string
	 */
	private function classToFilename ($class, $directory = '')
	{
		$matches = array();
		preg_match('/(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $class, $matches);

		$class = isset($matches['class']) ? $matches['class'] : '';
		$namespace = isset($matches['namespace']) ? $matches['namespace'] : '';

		return ($directory ? $this->normalize($directory) : '')
				.str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
				.str_replace('_', DIRECTORY_SEPARATOR, $class)
				.'.php';
	}
	// }}}
// }}}

}

// vim: ts=4 sw=4 fdm=marker
