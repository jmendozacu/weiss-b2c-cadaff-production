<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2013-02-10T15:47:06+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Mysql4/Destination/Collection.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Mysql4_Destination_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('xtento_orderexport/destination');
    }
}