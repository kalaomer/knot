<?php namespace Knot\Dict;

use Knot\Exceptions\FunctionExecuteException;
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
	private $helperList = [ ];

	/**
	 * Functions Routes.
	 */
	private $functionRoutes = [ ];


	/**
	 * Return instance of Self!
	 */
	public static function getInstance()
	{
		if ( ! self::$instance )
		{
			self::$instance = new self();
		}

		return self::$instance;
	}


	public function __construct()
	{
		$baseHelpers = self::getBaseHelpers();

		// Load core helpers!
		foreach ($baseHelpers as $helperObjectAddress)
		{
			$this->loadHelper(new $helperObjectAddress($this));
		}
	}


	public static function getBaseHelpers()
	{
		return [
			"\\Knot\\Dict\\Helpers\\PHPArrayChangerHelper",
			"\\Knot\\Dict\\Helpers\\PHPArrayEqualHelper",
			"\\Knot\\Dict\\Helpers\\UnderscoreHelper"
		];
	}


	/**
	 * Add new functions to static function list.
	 *
	 * @param          $functionRoute
	 * @param Callable $function
	 *
	 * @return false|Callable
	 */
	public function addRoute($functionRoute, callable $function)
	{
		if ( $this->isRoute($functionRoute) )
		{
			return false;
		}

		return $this->functionRoutes[$functionRoute] = $function;
	}


	/**
	 * @param string $functionName
	 *
	 * @return true|false
	 */
	public function isRoute($functionName)
	{
		return isset( $this->functionRoutes[$functionName] );
	}


	/**
	 * Load Helper!
	 *
	 * @param HelperInterface $helperObject
	 *
	 * @return false|HelperInterface
	 */
	public function loadHelper(HelperInterface $helperObject)
	{
		$helperName = $helperObject->getName();

		if ( $this->isHelper($helperName) )
		{
			return false;
		}

		$helperObject->addRoutes($this);

		return $this->helperList[$helperName] = $helperObject;
	}


	/**
	 * @param string $functionName
	 * @param array  $arguments
	 * @param \Knot\ParentArray
	 *
	 * @return mixed
	 * @throws WrongFunctionException|FunctionExecuteException
	 */
	public function execute($functionName, $arguments, $knot)
	{
		if ( $this->isRoute($functionName) )
		{
			$targetFunction = $this->getRoute($functionName);

			try
			{
				return call_user_func($targetFunction, $knot, $arguments, $functionName);
			}
			catch (\Exception $e)
			{
				throw new FunctionExecuteException($functionName);
			}
		}
		else
		{
			throw new WrongFunctionException($functionName);
		}
	}


	public function getRoute($staticFunctionName)
	{
		return $this->functionRoutes[$staticFunctionName];
	}


	public function isHelper($helperName)
	{
		return isset( $this->helperList[$helperName] );
	}
}
