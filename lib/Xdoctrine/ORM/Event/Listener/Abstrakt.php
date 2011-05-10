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

namespace Xdoctrine\Orm\Event\Listener;


#require_once 'Xdoctrine/ORM/Event/Listener/Interfaze.php';


abstract class Abstrakt implements \Xdoctrine\ORM\Event\Listener\Interfaze
{
	
	
	protected $_queue = array();
	protected $_entityClassName = null;
	protected $_events = array();
	
	
	public function __construct($entityClassName)
	{
		$this->_entityClassName = $entityClassName;
	}
	
	
	public function getEvents()
	{
		return $this->_events;
	}
	
	
	public function getQueue()
	{
		return $this->_queue;
	}
	
	
	public function isQueued($id)
	{
		return isset($this->_queue[$id]);
	}
	
	
	public function hasError($id)
	{
		return (isset($this->_queue[$id]) && $this->_queue[$id] == 0);
	}
	
	
	public function isFlushOk()
	{
		foreach($this->_queue as $item)
		{
			if($item == 0)
			{
				return false;
			}
		}
		
		return true;
	}
	
	
	public function isFlushError()
	{
		foreach($this->_queue as $item)
		{
			if($item == 0)
			{
				return true;
			}
		}
		
		return false;
	}
	
	
	public function countFlushOks()
	{
		$ok = 0;
		
		foreach($this->_queue as $item)
		{
			if($item == 1)
			{
				$ok++;
			}
		}
		
		return $ok;
	}
	
	
	public function countFlushErrors()
	{
		$errors = 0;
		
		foreach($this->_queue as $item)
		{
			if($item == 0)
			{
				$errors++;
			}
		}
		
		return $errors;
	}
	

}