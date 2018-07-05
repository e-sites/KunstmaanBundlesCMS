<?php

namespace Kunstmaan\TabBundle\ValueObject;

class PageTab {
	/**
	 * @var string
	 */
	private $internalName;

	/**
	 * @var string
	 */
	private $tabTitle;

	/**
	 * @var string
	 */
	private $template;

	/**
	 * @var string
	 */
	private $formTypeClass;

	/**
	 * @var integer
	 */
	private $position = 1;


	public function __construct($internalName, $tabTitle, $formTypeClass, $template = null, $position = 1)
	{
		$this->internalName = $internalName;
		$this->tabTitle = $tabTitle;
		$this->formTypeClass = $formTypeClass;
		$this->template = $template;
		$this->position = $position;
	}

	/**
	 * @return string
	 */
	public function getInternalName()
	{
		return $this->internalName;
	}

	/**
	 * @return string
	 */
	public function getTabTitle()
	{
		return $this->tabTitle;
	}

	/**
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * @return string
	 */
	public function getFormTypeClass()
	{
		return $this->formTypeClass;
	}

	/**
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
	}
}
