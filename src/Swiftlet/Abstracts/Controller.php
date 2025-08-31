<?php

namespace Swiftlet\Abstracts;

use \Swiftlet\Interfaces\App as AppInterface;
use \Swiftlet\Interfaces\Controller as ControllerInterface;
use \Swiftlet\Interfaces\View as ViewInterface;

/**
 * Controller class
 * @abstract
 */
abstract class Controller extends Common implements ControllerInterface
{
	/**
	 * Application instance
	 * @var \Swiftlet\Interfaces\App
	 */
	protected $app;

	/**
	 * View instance
	 * @var \Swiftlet\Interfaces\View
	 */
	protected $view;

	/**
	 * Page title
	 * @var string
	 */
	protected $title;

	/**
	 * Routes
	 * @var array
	 */
	protected $routes = array();

    /**
     * @param \Swiftlet\Interfaces\App $app
     */
    public function __construct(?AppInterface $app = null)
    {
        $this->app = $app;
    }

	/**
	 * Set application instance
	 * @param \Swiftlet\Interfaces\App $app
	 * @return \Swiftlet\Interfaces\Controller
	 */
	public function setApp(AppInterface $app)
	{
		$this->app = $app;

		return $this;
	}

	/**
	 * Set view instance
	 * @param \Swiftlet\Interfaces\App $app
	 * @return \Swiftlet\Interfaces\Controller
	 */
	public function setView(ViewInterface $view)
	{
		$this->view = $view;

		$reflection = new \ReflectionClass($this);

		$this->view->name = strtolower($reflection->getShortName());

		$this->view->pageTitle = $this->title;

		return $this;
	}

	/**
	 * Set page title
	 * @param string $app
	 * @return \Swiftlet\Interfaces\Controller
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		$this->view->pageTitle = $title;

		return $this;
	}

	/**
	 * Get routes
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Default action
	 */
	public function index()
	{ }
}
