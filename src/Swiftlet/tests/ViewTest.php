<?php

namespace Swiftlet;

require_once 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
	protected $view;

	protected function setUp(): void
	{
		$this->view = new View();
	}

	function testSetGet()
	{
		$this->assertEquals($this->view->set('key', 'value'), $this->view);
		$this->assertEquals($this->view->get('key'), 'value');
	}

	function test__set__get()
	{
		$this->view->key = 'value';

		$this->assertEquals($this->view->key, 'value');
	}

	function testGetRootPath()
	{
		$this->assertEquals($this->view->getRootPath, '');
	}

	function testHtmlEncode()
	{
		$this->assertEquals($this->view->htmlEncode('✓<>&"'), '✓&lt;&gt;&amp;&quot;');
	}

	function testHtmlDecode()
	{
		$this->assertEquals($this->view->htmlDecode('✓&lt;&gt;&amp;&quot;'), '✓<>&"');
	}

	function testRender()
	{
		$this->view->vendor = 'Mock';
		$this->view->name   = 'index';

		ob_start();

		$value = $this->view->render();

		ob_end_clean();

		$this->assertEquals($value, $this->view);
	}
}
