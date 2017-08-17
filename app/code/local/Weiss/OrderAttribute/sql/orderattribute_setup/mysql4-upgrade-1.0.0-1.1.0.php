<?php
/**
 * @author MLO
 *
 * Add sap_increment_id to order table
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('sales/order'),
        'sap_increment_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 255,
            'nullable' => true,
            'default' => null,
            'comment' => 'SAP Order ID'
        )
    );

$installer->getConnection()
    ->addColumn($installer->getTable('sales/order'),
        'crosschannel',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'nullable' => false,
            'default' => false,
            'comment' => 'CrossChannel Order'
        )
    );

$installer->endSetup();