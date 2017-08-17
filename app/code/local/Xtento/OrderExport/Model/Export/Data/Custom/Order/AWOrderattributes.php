<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2015-07-16T11:31:19+02:00
 * File:          app/code/local/Xtento/OrderExport/Model/Export/Data/Custom/Order/AWOrderattributes.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Export_Data_Custom_Order_AWOrderattributes extends Xtento_OrderExport_Model_Export_Data_Abstract
{
    public function getConfiguration()
    {
        return array(
            'name' => 'aheadWorks Order Attributes Export',
            'category' => 'Order',
            'description' => 'Export order attributes of the aheadWorks Order Attributes extension',
            'enabled' => true,
            'apply_to' => array(Xtento_OrderExport_Model_Export::ENTITY_ORDER, Xtento_OrderExport_Model_Export::ENTITY_INVOICE, Xtento_OrderExport_Model_Export::ENTITY_SHIPMENT, Xtento_OrderExport_Model_Export::ENTITY_CREDITMEMO),
            'third_party' => true,
            'depends_module' => 'AW_Orderattributes',
        );
    }

    public function getExportData($entityType, $collectionItem)
    {
        // Set return array
        $returnArray = array();

        if (!$this->fieldLoadingRequired('aw_orderattributes')) {
            return $returnArray;
        }

        try {
            $this->_writeArray = & $returnArray['aw_orderattributes'];

            // Output attributes
            $attributeCollection = Mage::helper('aw_orderattributes/order')->getAttributeValueCollectionForQuote($collectionItem->getOrder()->getQuoteId());
            foreach ($attributeCollection as $attribute) {
                $attributeModel = $attribute->getAttributeModel();
                $this->writeValue($attributeModel->getCode(), $attribute->getValue());
            }
        } catch (Exception $e) {

        }

        // Done
        return $returnArray;
    }
}