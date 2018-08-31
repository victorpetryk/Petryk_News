<?php

/**
 * News adminhtml form container block
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Block_Adminhtml_News_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'news_id';
        $this->_blockGroup = 'petryk_news';
        $this->_controller = 'adminhtml_news';

        parent::__construct();

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => "editForm.submit($('edit_form').action + 'back/edit/');",
            'class' => 'save'
        ), -100);
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_getModel()->getId()) {
            return Mage::helper('petryk_news')->__(
                'Edit News "%s"',
                $this->escapeHtml($this->_getModel()->getTitle())
            );
        } else {
            return Mage::helper('petryk_news')->__('Create News');
        }
    }

    /**
     * Get CSS class to display icon
     * near form container heading
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head ' . 'head-cms-page';
    }

    /**
     * Get form action url
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save', array('news_id' => $this->_getModel()->getId()));
    }

    /**
     * Get model
     *
     * @return mixed
     */
    protected function _getModel()
    {
        $model = Mage::registry('petryk_news');

        return $model;
    }
}