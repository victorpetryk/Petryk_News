<?php

/**
 * News adminhtml form block
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Block_Adminhtml_News_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('petryk_news');
        $helper = Mage::helper('petryk_news');

        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'html_id_prefix' => 'news_',
                'use_container' => true,
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $fieldset = $form->addFieldset('base_fieldset', array(
                'legend' => $helper->__('General Information'),
                'class' => 'fieldset-wide'
            )
        );

        if ($model->getId()) {
            $fieldset->addField('news_id', 'hidden', array(
                'name' => 'news_id',
            ));
        }

        // Set renderer for displaying news images on edit form
        $fieldset->addType('image', 'Petryk_News_Block_Adminhtml_News_Edit_Renderer_Image');

        $fieldset->addField('image', 'image', array(
            'name' => 'image',
            'label' => $helper->__('Image'),
            'title' => $helper->__('Image')
        ));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'class' => 'validate-no-html-tags',
            'label' => $helper->__('Title'),
            'title' => $helper->__('Title'),
            'required' => true
        ));

        $fieldset->addField('content', 'textarea', array(
            'name' => 'content',
            'label' => $helper->__('Content'),
            'title' => $helper->__('Content')
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}