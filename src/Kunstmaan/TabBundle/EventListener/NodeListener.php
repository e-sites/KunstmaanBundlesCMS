<?php
namespace Kunstmaan\TabBundle\EventListener;

use Kunstmaan\AdminBundle\Helper\FormWidgets\FormWidget;
use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\Tab;
use Kunstmaan\NodeBundle\Entity\HasNodeInterface;
use Kunstmaan\NodeBundle\Event\AdaptFormEvent;
use Kunstmaan\TabBundle\Entity\PageTabInterface;

class NodeListener
{
	/**
	 * @param AdaptFormEvent $event
	 */
	public function adaptForm(AdaptFormEvent $event)
	{
		$page = $event->getPage();

		if (!$page instanceof HasNodeInterface) {
			return;
		}

		if ($page->isStructureNode() === true) {
			return;
		}

		if(!$page instanceof PageTabInterface) {
			return;
		}

		$tabPane = $event->getTabPane();

		foreach($page->getTabs() as $pageTab) {
			$formWidget = new FormWidget();
			$formWidget->addType($pageTab->getInternalName(), $pageTab->getFormTypeClass(), $page);

			if(!empty($pageTab->getTemplate())) {
				$formWidget->setTemplate($pageTab->getTemplate());
			}

			$tabPane->addTab(new Tab($pageTab->getTabTitle(), $formWidget), $pageTab->getPosition());
		}
	}
}
