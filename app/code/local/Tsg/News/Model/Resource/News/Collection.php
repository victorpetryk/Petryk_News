<?php

/**
 * News collection
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Tsg_News_Model_Resource_News_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize collection
     */
    protected function _construct()
    {
        $this->_init('tsg_news/news');
    }
}