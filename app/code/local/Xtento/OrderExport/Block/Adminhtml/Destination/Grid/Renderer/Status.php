<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2013-02-10T17:02:34+01:00
 * File:          app/code/local/Xtento/OrderExport/Block/Adminhtml/Destination/Grid/Renderer/Status.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Block_Adminhtml_Destination_Grid_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return Mage::helper('xtento_orderexport')->__('Used in <strong>%d</strong> profile(s)', count($row->getProfileUsage()));
    }
}