<?php

/**
 * Xdoctrine - Sirprize's Doctrine2 Extensions
 *
 * @package    Xdoctrine
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    New BSD License
 */


namespace Xdoctrine\Common\Cache;


class ZendCache extends \Doctrine\Common\Cache\AbstractCache
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
			throw new \Xdoctrine\DBAL\Exception('call setZendCache() before '.__METHOD__);
		}
		
        return $this->_zendCache;
    }

    /**
     * {@inheritdoc}
     */
    protected function _doFetch($id) 
    {
        return $this->_zendCache->load($this->_prepareId($id));
    }

    /**
     * {@inheritdoc}
     */
    protected function _doContains($id)
    {
        return (bool) $this->_zendCache->test($this->_prepareId($id));
    }

    /**
     * {@inheritdoc}
     */
    protected function _doSave($id, $data, $lifeTime = false)
    {
		return $this->_zendCache->save($data, $this->_prepareId($id), array(), $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function _doDelete($id) 
    {
        return $this->_zendCache->remove($this->_prepareId($id));
    }
	
	
	protected function _prepareId($id)
	{
		return preg_replace('/[^a-zA-Z0-9_]/', '_', $id);
	}
	
	
	public function getIds()
	{
		return $this->_zendCache->getIds();
	}
}