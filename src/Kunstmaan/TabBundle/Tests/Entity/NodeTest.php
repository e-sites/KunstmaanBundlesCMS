<?php

namespace Kunstmaan\TabBundle\Tests\Entity;

use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\TabPane;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeBundle\Event\AdaptFormEvent;
use Kunstmaan\TabBundle\EventListener\NodeListener;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class NodeTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Node
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Node();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	public function testPageShouldHaveTab() {
		$request = new Request();
		$request->request = new ParameterBag();

		$formFactory = $this->getMockBuilder(FormFactory::class)
			->disableOriginalConstructor()
			->getMock()
		;

		$entity = new TestEntity();
		$this->object->setRef($entity);

		$tabPane = new TabPane('id', $request, $formFactory);

		$adaptFormEvent = new AdaptFormEvent($request, $tabPane, $entity);

		$nodeListener = new NodeListener();
		$nodeListener->adaptForm($adaptFormEvent);

		$tabs = $tabPane->getTabs();
		$title = null;

		if(isset($tabs[0])) {
			$title = $tabs[0]->getTitle();
		}

		$this->assertEquals('tab1_title', $title);
	}
}
