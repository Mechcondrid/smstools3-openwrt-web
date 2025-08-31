<?php

namespace Mock;

require_once 'vendor/autoload.php';

use \Mock\Controllers\Index as IndexController;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
	protected $controller;

	protected $view;

	protected function setUp(): void
	{
		$this->view       = new View;
		$this->controller = new IndexController;
	}

	public function testSetApp()
	{
		$app = new App($this->view, 'Mock');

		$this->assertEquals($this->controller->setApp($app), $this->controller);
	}

	public function testSetView()
	{
		$this->assertEquals($this->controller->setView($this->view), $this->controller);
	}

	public function testSetTitle()
	{
		$this->controller->setView($this->view);

		$this->assertEquals($this->controller->setTitle('title'), $this->controller);
	}
}
