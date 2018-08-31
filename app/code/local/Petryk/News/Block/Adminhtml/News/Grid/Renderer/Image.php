<?php

/**
 * Renderer for displaying news images in grid
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Block_Adminhtml_News_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $imageFile = $row->getImage();

        $imageSource = Mage::helper('petryk_news/image')->getImageFile($imageFile, 'thumbnail');

        $imageHTML = "<img src='{$imageSource}' width='50' height='50' alt='' style='margin-top: 3px; border: 1px solid #dadfe0;' />";

        return $imageHTML;
    }
}