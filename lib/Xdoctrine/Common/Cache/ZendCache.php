<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * @package    Xdoctrine
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    New BSD License
 */


namespace Xdoctrine\Common\Cache;


class ZendCache extends \Doctrine\Common\Cache\CacheProvider
{
    /**
     * @var \Zend_Cache_Core
     */
    private $_zendCache;

    /**
     * Sets the \Zend_Cache_Core instance to use.
     *
     * @param \Zend_Cache_Core $zendCache
     */
    public function setZendCache(\Zend_Cache_Core $zendCache)
    {
        $this->_zendCache = $zendCache;
    }

    /**
     * Gets the \Zend_Cache_Core instance used by the cache.
     *
     * @return \Zend_Cache_Core
     */
    public function getZendCache()
    {
		if($this->_zendCache === null)
		{
			throw new \Xdoctrine\Common\Exception('call setZendCache() before '.__METHOD__);
		}
		
        return $this->_zendCache;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id) 
    {
        return $this->getZendCache()->load($this->prepareId($id));
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return (bool) $this->getZendCache()->test($this->prepareId($id));
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = false)
    {
		return $this->getZendCache()->save($data, $this->prepareId($id), array(), $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id) 
    {
        return $this->getZendCache()->remove($this->prepareId($id));
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush() 
    {
        foreach($this->getIds() as $id)
        {
            $this->doDelete($id);
        }
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function doGetStats()
    {
        return null;
    }
	
	
	protected function prepareId($id)
	{
		return preg_replace('/[^a-zA-Z0-9_]/', '_', $id);
	}
	
	
	public function getIds()
	{
		return $this->getZendCache()->getIds();
	}
}