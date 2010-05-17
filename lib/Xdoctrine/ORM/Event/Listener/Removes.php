<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package    Xzend
 * @copyright  Copyright (c) 2009, Christian Hoegl, Switzerland (http://sitengine.org)
 * @license    http://sitengine.org/license/new-bsd     New BSD License
 */


namespace Xdoctrine\ORM\Event\Listener;


require_once 'Xdoctrine/ORM/Event/Listener/Abstrakt.php';


class Removes extends \Xdoctrine\ORM\Event\Listener\Abstrakt
{
	
	
	protected $_events = array(
		\Doctrine\ORM\Events::preRemove,
		\Doctrine\ORM\Events::postRemove
	);
	
	
	public function preRemove(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 0;
		}
    }
	
	
	public function postRemove(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {
		if($eventArgs->getEntity() instanceof $this->_entityClassName)
		{
			$this->_queue[$eventArgs->getEntity()->getId()] = 1;
		}
    }

}