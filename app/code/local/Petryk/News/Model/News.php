<?php

/**
 * News model
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Model_News extends Mage_Core_Model_Abstract
{
    /**
     * Initialize model
     */
    protected function _construct()
    {
        $this->_init('petryk_news/news');
    }

    protected function _beforeDelete()
    {
        $id = $this->getId();
        $model = $this->load($id);

        // Delete images related to model
        Mage::helper('petryk_news/image')->deleteImage($model->getImage());

        return parent::_beforeDelete();
    }
}