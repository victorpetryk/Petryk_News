<?php

/**
 * News Image helper
 *
 * @category    Petryk
 * @package     Petryk_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

class Petryk_News_Helper_Image extends Mage_Core_Helper_Abstract
{
    // Sub directory path to images
    protected $_subDirectoryPath = 'petryk' . DS . 'news' . DS;

    // Available image sizes
    protected $_sizes = array(
        'thumbnail' => '50x50',
        'medium' => '120x0'
    );

    // Placeholder image directory path
    protected $_placeholderImageDirectoryPath = 'frontend/default/default/images/catalog/product/placeholder';

    /**
     * Get image directory path
     *
     * @return string
     */
    public function getImageDirectoryPath()
    {
        return Mage::getBaseDir('media') . DS . $this->_subDirectoryPath;
    }

    /**
     * Get image directory URL
     *
     * @return string
     */
    public function getImageDirectoryUrl()
    {
        return Mage::getBaseUrl('media') . $this->_subDirectoryPath;
    }

    /**
     * Get placeholder image URL
     *
     * @return string
     */
    public function getPlaceholderImageUrl()
    {
        return Mage::getBaseUrl('skin') . DS . $this->_placeholderImageDirectoryPath . DS . 'image.jpg';
    }

    /**
     * Get Image file path or url
     *
     * @param $imageFile
     * @param string $size
     * @param bool $url
     * @return string
     */
    public function getImageFile($imageFile, $size = 'full', $url = true)
    {
        if (!$imageFile) {
            return $this->getPlaceholderImageUrl();
        }

        // Retrieve path or url to image
        if (!$url) {
            $path = $this->getImageDirectoryPath();
        } else {
            $path = $this->getImageDirectoryUrl();
        }


        if ($size !== 'full') {
            $imageFileChunks = explode('.', $imageFile);

            return $path . $imageFileChunks['0'] . '_' . $this->_sizes[$size] . '.' . $imageFileChunks['1'];
        }

        return $path . $imageFile;
    }

    /**
     * Upload image
     *
     * @param $fieldName
     * @param $model
     */
    public function uploadImage($fieldName, $model)
    {
        if (isset($_FILES[$fieldName]['name']) and (file_exists($_FILES[$fieldName]['tmp_name']))) {
            try {
                /* @var $uploader Mage_Core_Model_File_Uploader */
                $uploader = new Mage_Core_Model_File_Uploader($fieldName);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $uploader->save($this->getImageDirectoryPath(), $_FILES[$fieldName]['name']);

                // Resize image
                if (!empty($this->_sizes)) {
                    $this->_resizeImage($uploader->getUploadedFileName());
                }

                $model->setData($fieldName, $uploader->getUploadedFileName());

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                    ->addException($e, $this->__('There was an error when uploading the image.'));
            }
        } else {
            if ($model->getData($fieldName . '/delete') && $model->getData($fieldName . '/delete') == 1) {
                $imageFile = $model->getData($fieldName)['value'];

                // Delete image
                $this->deleteImage($imageFile);

                $model->setData($fieldName, '');
            }
        }
    }

    /**
     * Resize image
     *
     * @param $imageName
     */
    protected function _resizeImage($imageName)
    {
        $path = $this->getImageDirectoryPath();

        $imageNameChunks = explode('.', $imageName);

        foreach ($this->_sizes as $size) {

            $sizeParts = explode('x', $size);
            $width = $sizeParts[0];
            $height = $sizeParts[1];

            $resizedImageName = $imageNameChunks['0'] . '_' . $width . 'x' . $height . '.' . $imageNameChunks['1'];

            $image = new Varien_Image($path . $imageName);
            $image->constrainOnly(true);
            $image->keepAspectRatio(true);
            $image->keepFrame(true);
            $image->backgroundColor(array(255, 255, 255));
            $image->quality(100);
            $image->resize($width, (($height != 0) ? $height : null));

            $image->save($path . $resizedImageName);
        }
    }

    /**
     * Delete image
     *
     * @param $imageFile
     */
    public function deleteImage($imageFile)
    {
        // Delete original image
        $fullImageFilePath = $this->getImageFile($imageFile, 'full', false);

        if (file_exists($fullImageFilePath)) {
            unlink($fullImageFilePath);
        }

        // Delete resized images
        foreach (array_keys($this->_sizes) as $size) {
            $imageFilePath = $this->getImageFile($imageFile, $size, false);

            if (file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }
        }
    }
}