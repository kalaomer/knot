<?php

namespace Knot\Dict;

use \Knot\Exceptions\WrongFunctionException;
use \Knot\Dict\Helpers\HelperInterface;

class HelperManager {

	/**
	 * Helper Manager Object.
	 */
	protected static $instance = false;

	/**
	 * Helper list.
	 */
	private $helper = array();

	/**
	 * Functions Routes.
	 */
	private $functionRoutes = array();

	/**
	 * Return instance of Self!
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct()
	{
		$providerListContent = file_get_contents(__DIR__ . "/helpers.json");
		$providerList = json_decode($providerListContent, true);
		
		// Load core helpers!
		foreach ($providerList['providers'] as $helperObjectAddress) {
			$this->loadHelper(new $helperObjectAddress($this));
		}
	}

	/**
	 * Add new functions to static function list.
	 * @param $functioRoute
	 * @param Callable $function
	 * @return false|Callable
	 */
	public function addRoute($functionRoute, callable $function)
	{
		if ($this->isFunctionRoute($functionRoute)) {
			return false;
		}

		return $this->functionRoutes[$functionRoute] = $function;
	}

	/**
	 *
	 * @param string $functionName
	 *
	 * @return true|false
	 */
	public function isFunctionRoute($functionName)
	{
		return isset($this->functionRoutes[$functionName]);
	}

	/**
	 * Load Helper!
	 *
	 * @param HelperInterface $helperObject
	 * @return false|HelperInterface
	 */
	public function loadHelper(HelperInterface $helperObject)
	{
		$helperName = $helperObject->name();
		
		if ($this->isHelper($helperName))
		{
			return false;
		}

		$helperObject->addRoutes($this);

		return $this->helpers[$helperName] = $helperObject;
	}

	/**
	 * @param string $functionName
	 * @param array $arguments
	 * @param \Knot\ParentArray
	 * @return mixed
	 */
	public function execute($functionName, $arguments, $knot)
	{
		if ($this->isFunctionRoute($functionName))
		{
			$targetFunction = $this->getRoute($functionName);
			return call_user_func($targetFunction, $knot, $arguments);
		} else {
			throw new WrongFunctionException($functionName);
		}
	}

	public function getRoute($staticFunctionName)
	{
		return $this->functionRoutes[$staticFunctionName];
	}

	public function isHelper($helperName)
	{
		return isset($this->helpers[$helperName]);
	}
}
