<?php

/**
 * News resource model
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Tsg_News_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('tsg_news/news', 'news_id');
    }
}