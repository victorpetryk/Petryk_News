<?php

/**
 * News adminhtml grid container block
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Tsg_News_Block_Adminhtml_News extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'tsg_news';
        $this->_controller = 'adminhtml_news';
        $this->_headerText = Mage::helper('tsg_news')->__('Manage News');
        $this->_addButtonLabel = Mage::helper('tsg_news')->__('Add News');

        parent::__construct();
    }

    /**
     * CSS class with icon for container header
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head ' . 'head-cms-page';
    }
}