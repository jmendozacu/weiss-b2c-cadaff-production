<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2012-12-02T17:55:57+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/History.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_History extends Mage_Core_Model_Abstract
{
    /*
     * History model. Keeps track of which objects have been exported and which haven't
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('xtento_orderexport/history');
    }
}