<?php

/**
 * Install script
 *
 * @category    Tsg
 * @package     Tsg_News
 * @author      Victor Petryk <victor.petryk@transoftgroup.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('tsg_news/news');

$table = $installer->getConnection()->newTable($tableName)
    ->addColumn('news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ), 'News ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
        'nullable' => false
    ), 'News Title')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'News Content')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 250, array(
        'nullable' => false
    ), 'News Image')
    ->setComment('News Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();