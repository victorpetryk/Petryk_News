<?php

/**
 * News adminhtml controller
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Adminhtml_Petryk_NewsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Petryk_News_Adminhtml_Petryk_NewsController
     */
    protected function _initAction()
    {
        // Load layout, set active menu
        $this->loadLayout()
            ->_setActiveMenu('cms/petryk_news');

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

    /**
     * Grid action (for AJAX)
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('petryk_news/adminhtml_news_grid')->toHtml()
        );
    }

    /**
     * New action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit action
     */
    public function editAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('News'));

        $id = $this->getRequest()->getParam('news_id');
        $model = Mage::getModel('petryk_news/news');

        if ($id) {
            $model->load($id);

            // If news not exist, redirect to grid page with error message
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('petryk_news')->__('This news no longer exist.'));

                $this->_redirect('*/*/');

                return;
            }
        }

        // Changing title depends on create new or edit existing news
        $this->_title($model->getId() ? $model->getTitle() : $this->__('Create News'));

        // Get form data from session
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        // If data from session not empty
        // set this data to model
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('petryk_news', $model);

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $id = $this->getRequest()->getParam('news_id');
        $data = $this->getRequest()->getPost();
        $model = Mage::getModel('petryk_news/news');

        if ($id) {
            $model->load($id);
        }

        $model->setData($data);

        // If image was uploaded,
        // get previous value of image field
        if (isset($data['image']['value']) && !isset($data['image']['delete'])) {
            $model->setData('image', $data['image']['value']);
        }

        // Upload image
        Mage::helper('petryk_news/image')->uploadImage('image', $model);

        try {
            $model->save();

            $this->_getSession()->addSuccess(Mage::helper('petryk_news')->__('News was saved successfully.'));
            $this->_getSession()->setFormData(false);

            // Check whether the "Save and Continue to edit" button was clicked.
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('news_id' => $model->getId(), '_current' => true));

                return;
            }

            $this->_redirect('*/*/');

            return;

        } catch (Exception $e) {
            $this->_getSession()->addException($e,
                Mage::helper('petryk_news')->__('Error occurred while saving news.'));
        }

        // Save data from form to session
        $this->_getSession()->setFormData($data);

        $this->_redirect('*/*/edit', array('news_id' => $this->getRequest()->getParam('news_id')));

        return;
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('news_id');

        if ($id) {
            try {
                $model = Mage::getModel('petryk_news/news');
                $model->setId($id)->delete();

                $this->_getSession()->addSuccess(Mage::helper('petryk_news')->__('News was deleted successfully.'));

                $this->_redirect('*/*/');

                return;

            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());

                $this->_redirect('*/*/edit', array('news_id' => $id));

                return;
            }
        }

        $this->_getSession()->addError(Mage::helper('petryk_news')->__('News for delete does not exist.'));

        $this->_redirect('*/*/');

        return;
    }

    /**
     * Mass delete action
     */
    public function massDeleteAction()
    {
        $newsIds = $this->getRequest()->getParam('news_ids');

        if (!is_array($newsIds)) {
            $this->_getSession()->addError($this->__('Please, select news.'));
        } else {
            if (!empty($newsIds)) {
                try {
                    foreach ($newsIds as $newsId) {
                        $model = Mage::getModel('petryk_news/news')->load($newsId);
                        $model->delete();
                    }

                    $this->_getSession()->addSuccess(
                        $this->__('In total, %d news have been deleted.', count($newsIds))
                    );

                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }

        $this->_redirect('*/*/');
    }
}