<?php

/**
 * Nette Framework
 *
 * Copyright (c) 2004, 2009 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license" that is bundled
 * with this package in the file license.txt.
 *
 * For more information please see http://nettephp.com
 *
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @license    http://nettephp.com/license  Nette license
 * @link       http://nettephp.com
 * @category   Nette
 * @package    Nette\Application
 * @version    $Id: Application.php 230 2009-03-19 12:16:22Z david@grudl.com $
 */



require_once dirname(__FILE__) . '/../Object.php';

require_once dirname(__FILE__) . '/../Application/ApplicationException.php';



/**
 * Front Controller.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @package    Nette\Application
 */
class Application extends Object
{
	/** @var int */
	public static $maxLoop = 20;

	/** @var array */
	public $defaultServices = array(
		'Nette\Application\IRouter' => 'Nette\Application\MultiRouter',
		'Nette\Application\IPresenterLoader' => 'Nette\Application\PresenterLoader',
	);

	/** @var bool enable fault barrier? */
	public $catchExceptions;

	/** @var string */
	public $errorPresenter;

	/** @var array of function(Application $sender) */
	public $onStartup;

	/** @var array of function(Application $sender, \Exception $e = NULL) */
	public $onShutdown;

	/** @var array of function(Application $sender, PresenterRequest $request) */
	public $onRequest;

	/** @var array of function(Application $sender, \Exception $e) */
	public $onError;

	/** @var array of string */
	public $allowedMethods = array('GET', 'POST', 'HEAD');

	/** @var array of PresenterRequest */
	private $requests = array();

	/** @var Presenter */
	private $presenter;

	/** @var ServiceLocator */
	private $serviceLocator;



	/**
	 * Dispatch a HTTP request to a front controller.
	 */
	public function run()
	{
		$httpRequest = $this->getHttpRequest();
		$httpResponse = $this->getHttpResponse();

		$httpRequest->setEncoding('UTF-8');
		$httpResponse->setHeader('X-Powered-By', 'Nette Framework');

		if (Environment::getVariable('baseUri') === NULL) {
			Environment::setVariable('baseUri', $httpRequest->getUri()->basePath);
		}

		// check HTTP method
		$method = $httpRequest->getMethod();
		if ($this->allowedMethods) {
			if (!in_array($method, $this->allowedMethods, TRUE)) {
				$httpResponse->setCode(IHttpResponse::S501_NOT_IMPLEMENTED);
				$httpResponse->setHeader('Allow', implode(',', $this->allowedMethods));
				$method = htmlSpecialChars($method);
				die("<h1>Method $method is not implemented</h1>");
			}
		}

		// dispatching
		$request = NULL;
		$hasError = FALSE;
		do {
			try {
				if (count($this->requests) > self::$maxLoop) {
					throw new ApplicationException('Too many loops detected in application life cycle.');
				}

				if (!$request) {
					$this->onStartup($this);

					// default router
					$router = $this->getRouter();
					if ($router instanceof MultiRouter && !count($router)) {
						$router[] = new SimpleRouter(array(
							'presenter' => 'Default',
							'action' => 'default',
						));
					}

					// routing
					$request = $router->match($httpRequest);
					if (!($request instanceof PresenterRequest)) {
						$request = NULL;
						throw new BadRequestException('No route for HTTP request.');
					}

					if (strcasecmp($request->getPresenterName(), $this->errorPresenter) === 0) {
						throw new BadRequestException('Invalid request.');
					}
				}

				$this->requests[] = $request;
				$this->onRequest($this, $request);

				// Instantiate presenter
				$presenter = $request->getPresenterName();
				try {
					$class = $this->getPresenterLoader()->getPresenterClass($presenter);
					$request->modify('name', $presenter);
				} catch (InvalidPresenterException $e) {
					throw new BadRequestException($e->getMessage(), 404, $e);
				}
				$this->presenter = new $class($request);

				// Instantiate topmost service locator
				$this->presenter->setServiceLocator(new ServiceLocator($this->serviceLocator));

				// Execute presenter
				$this->presenter->run();
				break;

			} catch (RedirectingException $e) {
				// not error, presenter redirects to new URL
				$httpResponse->redirect($e->getUri(), $e->getCode());
				break;

			} catch (ForwardingException $e) {
				// not error, presenter forwards to new request
				$request = $e->getRequest();

			} catch (AbortException $e) {
				// not error, application is correctly terminated
				unset($e);
				break;

			} catch (Exception $e) {
				// fault barrier
				if ($this->catchExceptions === NULL) {
					$this->catchExceptions = Environment::isProduction();
				}

				if (!$this->catchExceptions) {
					throw $e;
				}

				$this->onError($this, $e);

				if ($hasError) {
					$e = new ApplicationException('An error occured while executing error-presenter', 0, $e);

				} elseif ($this->errorPresenter) {
					$hasError = TRUE;
					$request = new PresenterRequest(
						$this->errorPresenter,
						PresenterRequest::FORWARD,
						array('exception' => $e)
					);
					continue;
				}

				if ($e instanceof BadRequestException) {
					if (!$httpResponse->isSent()) {
						$httpResponse->setCode($e->getCode());
					}
					echo "<title>404 Not Found</title>\n\n<h1>Not Found</h1>\n\n<p>The requested URL was not found on this server.</p>";
					break;

				} else {
					if (!$httpResponse->isSent()) {
						$httpResponse->setCode(500);
					}
					Debug::processException($e, FALSE);
					echo "<title>500 Internal Server Error</title>\n\n<h1>Server Error</h1>\n\n",
						"<p>The server encountered an internal error and was unable to complete your request. Please try again later.</p>";
					break;
				}
			}
		} while (1);

		$this->onShutdown($this, isset($e) ? $e : NULL);
	}



	/**
	 * Returns all processed requests.
	 * @return array of PresenterRequest
	 */
	final public function getRequests()
	{
		return $this->requests;
	}



	/**
	 * Returns current presenter.
	 * @return Presenter
	 */
	final public function getPresenter()
	{
		return $this->presenter;
	}



	/********************* services ****************d*g**/



	/**
	 * Gets the service locator (experimental).
	 * @return IServiceLocator
	 */
	final public function getServiceLocator()
	{
		if ($this->serviceLocator === NULL) {
			$this->serviceLocator = new ServiceLocator(Environment::getServiceLocator());

			foreach ($this->defaultServices as $name => $service) {
				if ($this->serviceLocator->getService($name, FALSE) === NULL) {
					$this->serviceLocator->addService($service, $name);
				}
			}
		}
		return $this->serviceLocator;
	}



	/**
	 * Gets the service object of the specified type.
	 * @param  string service name
	 * @param  bool   throw exception if service doesn't exist?
	 * @return mixed
	 */
	final public function getService($name, $need = TRUE)
	{
		return $this->getServiceLocator()->getService($name, $need);
	}



	/**
	 * Returns router.
	 * @return IRouter
	 */
	public function getRouter()
	{
		return $this->getServiceLocator()->getService('Nette\Application\IRouter');
	}



	/**
	 * Changes router.
	 * @param  IRouter
	 * @return void
	 */
	public function setRouter(IRouter $router)
	{
		$this->getServiceLocator()->addService($router, 'Nette\Application\IRouter');
	}



	/**
	 * Returns presenter loader.
	 * @return IPresenterLoader
	 */
	public function getPresenterLoader()
	{
		return $this->getServiceLocator()->getService('Nette\Application\IPresenterLoader');
	}



	/********************* request serialization ****************d*g**/



	/**
	 * @return string
	 */
	public function storeRequest()
	{
		$session = $this->getSession()->getNamespace('Nette.Application/requests');
		do {
			$key = substr(md5(lcg_value()), 0, 4);
		} while (isset($session->$key));

		$session->$key = end($this->requests);
		$session->setExpiration(10 * 60, 'requests');
		return $key;
	}



	/**
	 * @param  string
	 * @return void
	 */
	public function restoreRequest($key)
	{
		$session = $this->getSession()->getNamespace('Nette.Application/requests');
		if (isset($session->$key)) {
			$request = $session->$key;
			unset($session->$key);
			throw new ForwardingException($request);
		}
	}



	/********************* backend ****************d*g**/



	/**
	 * @return IHttpRequest
	 */
	protected function getHttpRequest()
	{
		return Environment::getHttpRequest();
	}



	/**
	 * @return IHttpResponse
	 */
	protected function getHttpResponse()
	{
		return Environment::getHttpResponse();
	}



	/**
	 * @return Session
	 */
	protected function getSession()
	{
		return Environment::getSession();
	}

}
