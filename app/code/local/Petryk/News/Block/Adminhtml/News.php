<?php

/**
 * News adminhtml grid container block
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Block_Adminhtml_News extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'petryk_news';
        $this->_controller = 'adminhtml_news';
        $this->_headerText = Mage::helper('petryk_news')->__('Manage News');

        parent::__construct();
    }

    /**
     * Get CSS class to display icon
     * near grid container heading
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head ' . 'head-cms-page';
    }
}