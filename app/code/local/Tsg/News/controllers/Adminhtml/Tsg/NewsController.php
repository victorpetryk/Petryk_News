<?php

/**
 * News adminhtml controller
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Tsg_News_Adminhtml_Tsg_NewsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Tsg_News_Adminhtml_Tsg_NewsController
     */
    protected function _initAction()
    {
        // Load layout, set active menu
        $this->loadLayout()
            ->_setActiveMenu('cms/tsg_news');

        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('News'));

        $this->_initAction();
        $this->renderLayout();
    }
}