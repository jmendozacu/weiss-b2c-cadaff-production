<?php

/**
 * Product:       Xtento_OrderExport (1.8.5)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-07-30T07:28:55+00:00
 * Last Modified: 2012-12-07T18:54:59+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Export/Entity/Shipment.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Export_Entity_Shipment extends Xtento_OrderExport_Model_Export_Entity_Abstract
{
    protected $_entityType = Xtento_OrderExport_Model_Export::ENTITY_SHIPMENT;

    protected function _construct()
    {
        $collection = Mage::getResourceModel('sales/order_shipment_collection')
            ->addAttributeToSelect('*');
        $this->_collection = $collection;
        parent::_construct();
    }
}