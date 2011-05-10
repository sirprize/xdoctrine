<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * @package    Xdoctrine
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    New BSD License
 */


namespace Xdoctrine\DBAL\Logging;


class ZendSQLLogger implements \Doctrine\DBAL\Logging\SQLLogger
{
    /**
     * @var \Zend_Log
     */
    private $_zendLog = null;

    /**
     * Sets the \Zend_Log instance to use.
     *
     * @param \Zend_Log $zendLog
     */
    public function setZendLog(\Zend_Log $zendLog)
    {
        $this->_zendLog = $zendLog;
    }

    /**
     * Gets the \Zend_Log instance used by the cache.
     *
     * @return \Zend_Log
     */
    public function getZendLog()
    {
		if($this->_zendLog === null)
		{
			throw new \Xdoctrine\DBAL\Exception('call setZendLog() before '.__METHOD__);
		}
		
        return $this->_zendLog;
    }
	
	
	
	public function startQuery($sql, array $params = null, array $types = null)
	{
		$p = '';
		
		foreach($params as $k => $v)
		{
			if(is_object($v))
			{
				continue;
			}
			$p .= (($p) ? ', ' : '').$k.' => '.$v;
		}
		
		$this->getZendLog()->debug($sql);
		$this->getZendLog()->debug("PARAMS: $p");
	}

    
    public function stopQuery()
	{}
}