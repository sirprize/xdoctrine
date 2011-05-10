<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * @package    Xdoctrine
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    New BSD License
 */


namespace Xdoctrine\ORM\Event\Listener;


class Updates extends \Xdoctrine\ORM\Event\Listener\Abstrakt
{
	
	
	protected $_events = array(
		\Doctrine\ORM\Events::preUpdate,
		\Doctrine\ORM\Events::postUpdate
	);
	
	
	public function preUpdate(\Doctrine\ORM\Event\PreUpdateEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 0;
		}
    }
	
	
	public function postUpdate(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 1;
		}
    }
	
}