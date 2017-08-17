<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2013-03-07T13:12:11+01:00
 * File:          app/code/local/Xtento/OrderExport/Block/Adminhtml/Log/Grid/Renderer/Type.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Block_Adminhtml_Log_Grid_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
{
    public function render(Varien_Object $row)
    {
        if ($row->getExportType() != Xtento_OrderExport_Model_Export::EXPORT_TYPE_EVENT) {
            return parent::render($row);
        } else {
            return parent::render($row)." (".Mage::helper('xtento_orderexport')->__('Event').": ".$row->getExportEvent().")";
        }
    }
}