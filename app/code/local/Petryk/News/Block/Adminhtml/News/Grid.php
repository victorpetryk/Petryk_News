<?php

/**
 * News adminhtml grid block
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('newsGrid');
        $this->setDefaultSort('news_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        /* @var $collection Petryk_News_Model_Resource_News_Collection */
        $collection = Mage::getModel('petryk_news/news')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('news_id', array(
            'header' => Mage::helper('petryk_news')->__('ID'),
            'align' => 'left',
            'width' => '50px',
            'type' => 'number',
            'index' => 'news_id'
        ));

        $this->addColumn('image', array(
            'header' => Mage::helper('petryk_news')->__('Image'),
            'align' => 'center',
            'width' => '60px',
            'renderer' => Mage::getBlockSingleton('petryk_news/adminhtml_news_grid_renderer_image'),
            'index' => 'image',
            'filter' => false,
            'sortable' => false,
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('petryk_news')->__('Title'),
            'align' => 'left',
            'type' => 'text',
            'index' => 'title'
        ));

        $this->addColumn('content', array(
            'header' => Mage::helper('petryk_news')->__('Content'),
            'align' => 'left',
            'type' => 'text',
            'index' => 'content',
            'truncate' => 125,
            'filter' => false,
            'escape' => true,
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('news_id');
        $this->getMassactionBlock()->setFormFieldName('news_ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('petryk_news')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('petryk_news')->__('Are You sure?'),
        ));

        return parent::_prepareMassaction();
    }

    /**
     * Get row URL
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('news_id' => $row->getId()));
    }

    /**
     * Get grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}