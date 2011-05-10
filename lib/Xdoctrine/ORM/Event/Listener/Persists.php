<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * @package    Xdoctrine
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    New BSD License
 */


namespace Xdoctrine\ORM\Event\Listener;


class Persists extends \Xdoctrine\ORM\Event\Listener\Abstrakt
{
	
	
	protected $_events = array(
		\Doctrine\ORM\Events::prePersist,
		\Doctrine\ORM\Events::postPersist
	);
	
	
	public function prePersist(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 0;
		}
    }
	
	
	public function postPersist(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 1;
		}
    }

}