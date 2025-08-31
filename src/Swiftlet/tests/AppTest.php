<?php

namespace Mock;

require_once 'vendor/autoload.php';

use \Mock\Controllers\Index as IndexController;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
	protected $app;

	protected $view;

	protected function setUp(): void
	{
		$this->view = new View;

		$this->app = new App($this->view, 'Mock');

		set_error_handler(array($this->app, 'error'), E_ALL);

		date_default_timezone_set('UTC');
	}

	function testDispatchController()
	{
		$this->assertEquals($this->app->dispatchController(), $this->app);
	}

	function testServe()
	{
		$this->view->name = 'index';
        $this->app->setController(new IndexController);

		$this->assertEquals($this->app->serve(), $this->app);
	}

	function testLoadPlugins()
	{
		$this->assertEquals($this->app->loadPlugins(), $this->app);
	}

	function testSetGetConfig()
	{
		$this->assertEquals($this->app->setConfig('key', 'value'), $this->app);
		$this->assertEquals($this->app->getConfig('key'), 'value');
	}

	function testRegisterHook()
	{
		$this->assertEquals($this->app->registerHook('test', new IndexController, new View), $this->app);
	}

        function testError()
        {
                $this->expectException(\ErrorException::class);
                $this->app->error(null, null, null, null);
        }
}
