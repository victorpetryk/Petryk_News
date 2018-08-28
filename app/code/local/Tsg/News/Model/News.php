<?php

/**
 * News model
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Tsg_News_Model_News extends Mage_Core_Model_Abstract
{
    /**
     * Initialize model
     */
    protected function _construct()
    {
        $this->_init('tsg_news/news');
    }
}